#!/bin/sh
make clean
phpize --clean
phpize
rm -f *.i *.ii
./configure --with-sapnwrfc=/home/piers/code/sap/nwrfcsdk  && make && sudo cp ./modules/sapnwrfc.so /usr/lib/php5/20060613/ &&  php -r 'dl("sapnwrfc.so"); echo sapnwrfc_rfcversion()."\n".sapnwrfc_version()."\n";'
