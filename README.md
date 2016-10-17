# kezmuvesprogramozo.hu blog 

Personal blog – [https://kezmuvesprogramozo.hu/](https://kezmuvesprogramozo.hu/)

### Setup

````
chmod -R 755 .
chmod -R 777 var/logs
chmod -R 777 var/cache
chmod -R 777 var/content
chmod -R 777 web/content
export SYMFONY_ENV=prod
composer install --no-dev --optimize-autoloader
npm install
bower install
grunt build
````

### Synchronize content

````
bin/console lencse:sync
````

[![Build Status](https://travis-ci.org/lencse/ll-blog.svg?branch=master)](https://travis-ci.org/lencse/ll-blog)
