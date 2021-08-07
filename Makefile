export PHP_CS_FIXER_IGNORE_ENV=1
SHELL=/bin/bash
PHP=$$(command -v php)
VINFO=https://www.pochta.ru/database/ops

.PHONY=all
all: docs/json docs/json/index.json
	mkdir -p build/cache
	$(PHP) vendor/bin/php-cs-fixer fix
	git add docs/json/

.PHONY=check
check:
	curl -I --silent --show-error --fail -o /dev/null $(VINFO)
	# All clear!

ops.txt:
	echo -e $$(curl -s $(VINFO)) > ops.txt
	grep -q Эталонный ops.txt

PIndx.zip: ops.txt
	wget --content-disposition "https://www.pochta.ru$$(cat ops.txt | grep -Eo '(/documents/[^)]+PIndx.zip[^)]+)')"
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

docs/json: PIndx.tsv vendor/autoload.php
	$(PHP) bin/JSONIndex.php
	touch --no-create docs/json/

docs/json/index.json: PIndx.tsv vendor/autoload.php
	$(PHP) bin/JSONListIndex.php

.PHONY=cs
cs:
	$(PHP) vendor/bin/php-cs-fixer fix -v

.PHONY=clean
clean:
	rm -fv PIndx.tsv PIndx.txt PIndx.dbf PIndx.zip ops.txt
	git rm -qr docs/json/

.PHONY=cron-clean
cron-clean: clean
	find composer.lock vendor/autoload.php -mtime +30 -delete

.PHONY=test
test: vendor/autoload.php
	$(PHP) vendor/bin/phpunit

vendor/autoload.php: composer.lock
	$(PHP) -v
	composer install

composer.lock: composer.json
	composer update
	touch -r composer.lock composer.json

.PHONY=cron
cron: all version

.PHONY=version
version: ops.txt
	# Downloading ...
	elinks -version | head -n 1
	cat ops.txt | \
		grep -a -A1 .формирован | \
		grep -a -oE [0-9]{2}\\.[0-9]{2}\\.[0-9]{4} | \
		sed -E 's,([0-9]{2}).([0-9]{2}).([0-9]{4}),\3-\2-\1,g' | \
		grep -o [0-9]*-[0-9]*-[0-9]* | head -n 1 > docs/_data/last-update-date
	sed s/date-updated/$$(cat docs/_data/last-update-date)/ docs/_data/status.yml.template > docs/_data/status.yml
	git add docs/_data/status.yml
	cat docs/_data/last-update-date

.PHONY=commit
commit:
	if ! git diff --cached --quiet; then git commit -m "Automatic build for $$(cat docs/_data/last-update-date)"; git push; fi

docs/_includes/default.html:
	wget -O docs/_includes/default.html https://raw.githubusercontent.com/pages-themes/dinky/master/_layouts/default.html
