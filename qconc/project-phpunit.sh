#!/bin/bash


git clone git@github.com:akamus/project-phpunit.git

cd project-phpunit

composer install

./vendor/bin/phpunit tests --colors
