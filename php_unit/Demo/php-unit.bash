#! Installation
composer require --dev phpunit/phpunit

#! Verification

./vendor/bin/phpunit --version

#! Lancement des tests
# lancement des tests dans le dossier tests
./vendor/bin/phpunit tests
# lancement des tests uniquement dans le dossier tests/EmailTest.php
./vendor/bin/phpunit tests/EmailTest.php