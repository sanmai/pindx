export PHP_CS_FIXER_IGNORE_ENV=1
SHELL=/bin/bash
PHP=$$(command -v php)
PINDXZIP=http://vinfo.russianpost.ru/database/PIndx.zip

.PHONY=all
all: src/MainDirectory.php src/PrefixDirectory.php docs/json src/ByCity
	mkdir -p build/cache
	$(PHP) vendor/bin/php-cs-fixer fix -v
	git add src/ docs/json/

.PHONY=check
check:
	curl -I --silent --show-error --fail -o /dev/null $(PINDXZIP)
	# All clear!

PIndx.zip:
	wget $(PINDXZIP)
	unzip -t PIndx.zip

PIndx.dbf: PIndx.zip
	unzip -p PIndx.zip > PIndx.dbf

PIndx.txt: PIndx.dbf
	@$$(command -v dbview) --version
	dbview -o -e -r PIndx.dbf > PIndx.txt || true

PIndx.tsv: PIndx.dbf
	@$$(command -v dbview) --version
	dbview PIndx.dbf | iconv -f CP866 | grep -q $$'\t' && echo "Found a tab character, cannot proceed with .tsv conversion" || true
	dbview -t -b -d$$'\t' PIndx.dbf | iconv -f CP866 > PIndx.tsv
	grep -q ^0 PIndx.tsv && echo "Found a postal code beginning with a zero" || true

src/MainDirectory.php: PIndx.tsv vendor/autoload.php
	$(PHP) bin/MainDirectory.php

src/PrefixDirectory.php: PIndx.tsv vendor/autoload.php
	$(PHP) bin/PrefixDirectory.php

docs/json: PIndx.tsv
	$(PHP) bin/JSONIndex.php
	touch --no-create docs/json/

src/ByCity: PIndx.tsv vendor/autoload.php
	$(PHP) bin/PHPExport.php
	find src/ByCity -type f -print0 | xargs -r -0 -P$$(nproc) -n64 $(PHP) vendor/bin/php-cs-fixer fix --using-cache=no --quiet --config .php_cs.dist
	touch --no-create src/ByCity/

.PHONY=clean
clean:
	rm -fv PIndx.tsv PIndx.txt PIndx.dbf PIndx.zip
	git rm -fr src/ByCity/ docs/json/

.PHONY=test
test: vendor/autoload.php
	$(PHP) vendor/bin/phpunit

vendor/autoload.php:
	$(PHP) -v
	composer install

.PHONY=cron
cron: all
	if ! git diff --cached --quiet; then git commit -m "Automatic build on $$(date +%Y-%m-%d)"; git push; exit 1; fi
