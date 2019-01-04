EA: Eating Project
======

* Production:   http://eating-project.herokuapp.com/
* Date          September 22, 2017
* Symfony:      3.3.5
* PHP:          7.1.x
* dependencies: Composer, Node,js, npm, Bower, Gulp, SASS

## To install project

* ```git clone git@github.com:katebalan/eating_project.git```
* ```cd eating_project/``` - enter to project's folder
* ```composer install```
A file app/config/parameters.yml must be auto-generated during the composer install.
Make sure that you fill it correct:
``` app/config/parameters.yml
parameters:
    mailer_transport: smtp
    mailer_host: 127.0.0.1
    mailer_user: null
    mailer_password: null
    secret: ThisTokenIsNotSoSecretChangeIt

```
* ```./bin/console doctrine:database:create``` - to create database
* ```./bin/console doctrine:schema:create``` - to create schema
* ```./bin/console doctrine:fixtures:load``` - to use fixtures
* ```./bin/console server:start``` - to start build-in server
* open in browser http://127.0.0.1:8000/

if you have some problems with cache, logs or sessions, you can use:
```chmod 777 -R var/cache var/sessions var/logs```

in web/data/ folder you can find database.

## Gulpfile's command
* ``` gulp css ``` - compile sass files in one file
* ``` gulp js ```  - compile all js files in one file
* ``` gulp img ```  - add all images to web/img folder
