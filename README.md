eating_project
======

* Date          September 22, 2017
* Symfony:      3.4.17
* PHP:          7.1.x
* dependencies: Composer, Node,js, npm, Bower, Gulp, SASS

# To install project

* composer install
* create file app/config/parameters.yml
```
# This file is auto-generated during the composer install
parameters:
    database_host: 127.0.0.1
    database_port: null
    database_name: eating_project
    database_user: root
    database_password: garrypotter
    mailer_transport: smtp
    mailer_host: 127.0.0.1
    mailer_user: ket11141@gmail.com
    mailer_password: null
    secret: ThisTokenIsNotSoSecretChangeIt

```
then you need create database:
```
./bin/console doctrine:database:create
```
and make migrations:
```
./bin/console doctrine:migrations:migrate
```
you can use fixtures with command
```
php bin/console doctrine:fixtures:load
```
kjdkjn vjk 
* npm install
* bower install
uh kjh kj nkjc 

#### HOW TO FIX PROBLEMS WITH .gitignore file on repository

```
git rm -r --cached .
git add .
git commit -m "fixed untracked files"
```
Useful links:

```
composer require doctrine/doctrine-migrations-bundle
https://knpuniversity.com/screencast/symfony-forms/the-form-type-class

```

#### **add new migrations:**
```
./bin/console doctrine:migrations:diff
./bin/console doctrine:migrations:migrate

```
#### **forms**
```
http://symfony.com/doc/current/reference/forms/types.html
https://web-programming.com.ua/dobavlenie-datepicker-vidzhet-kalendarya-na-jquery/
https://css-tricks.com/gulp-for-beginners/

#TO DO
https://knpuniversity.com/screencast/symfony-security/logout-and-last-username#play

```

# gulpfile's command
```
gulp sass
```
- compile sass files in one file
```
gulp js
``` 
- compile all js files in one file
```
gulp img
``` 
- add all images to web/img folder


# git 
git push -u origin consumption

You do these steps:

git checkout -b your_branch
git push -u origin your_branch
show all branches (see result):

git branch
