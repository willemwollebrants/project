#!/bin/bash
php system/util/setup.php;
rm -rf .git/;
rm -rf system/util/;
cd system/;
composer update;
cd ..
rm -f setup.sh;
