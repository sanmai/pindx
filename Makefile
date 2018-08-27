SHELL=/bin/bash

all: src/MainDirectory.php src/PrefixDirectory.php

clean:
	rm -v PIndx.tsv PIndx.txt

PIndx.zip:
	wget http://vinfo.russianpost.ru/database/PIndx.zip
	unzip -t PIndx.zip

PIndx.dbf: PIndx.zip
	unzip -p PIndx.zip > PIndx.dbf

PIndx.txt: PIndx.dbf
	dbview -o -e -r PIndx.dbf > PIndx.txt || true

PIndx.tsv: PIndx.dbf
	dbview PIndx.dbf | iconv -f CP866 | grep -q $$'\t' && echo "Found a tab character, cannot proceed with .tsv conversion" || true
	dbview -t -b -d$$'\t' PIndx.dbf | iconv -f CP866 > PIndx.tsv
	grep -q ^0 PIndx.tsv && echo "Found a postal code beginning with a zero" || true

src/MainDirectory.php: PIndx.tsv
	php bin/MainDirectory.php

src/PrefixDirectory.php: PIndx.tsv
	php bin/PrefixDirectory.php
