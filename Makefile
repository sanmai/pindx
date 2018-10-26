SHELL=/bin/bash

all: src/MainDirectory.php src/PrefixDirectory.php docs/json src/ByCity
	mkdir -p build/cache
	php vendor/bin/php-cs-fixer fix -v

clean:
	rm -v PIndx.tsv PIndx.txt

PIndx.zip:
	wget http://vinfo.russianpost.ru/database/PIndx.zip
	unzip -t PIndx.zip

PIndx.dbf: PIndx.zip
	unzip -p PIndx.zip > PIndx.dbf

PIndx.txt: PIndx.dbf
	@$$(command -v dbview) --version
	dbview -o -e -r PIndx.dbf > PIndx.txt || true

PIndx.tsv: PIndx.dbf
	dbview PIndx.dbf | iconv -f CP866 | grep -q $$'\t' && echo "Found a tab character, cannot proceed with .tsv conversion" || true
	dbview -t -b -d$$'\t' PIndx.dbf | iconv -f CP866 > PIndx.tsv
	grep -q ^0 PIndx.tsv && echo "Found a postal code beginning with a zero" || true

src/MainDirectory.php: PIndx.tsv
	php bin/MainDirectory.php

src/PrefixDirectory.php: PIndx.tsv
	php bin/PrefixDirectory.php

docs/json: PIndx.tsv
	php bin/JSONIndex.php
	touch docs/json

src/ByCity: PIndx.tsv
	php bin/PHPExport.php
	find src/ByCity -type f -print0 | xargs -0 -P$$(nproc) -n64 php vendor/bin/php-cs-fixer fix --using-cache=no --quiet --config .php_cs.dist
	touch src/ByCity
