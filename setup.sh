#!/bin/bash
php system/util/setup.php;
rm -rf .git/;
rm -rf system/util/;
cd system/;
composer update;
rm -f setup.sh;
