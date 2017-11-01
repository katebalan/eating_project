eating_project
======

A Symfony project created on September 22, 2017, 4:15 pm.

# To install project

```
composer install
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

#### HOW TO FIX PROBLEMS WITH .gitignore file on repository

```
git rm -r --cached .
git add .
git commit -m "fixed untracked files"
```
Just do it

```
composer require doctrine/doctrine-migrations-bundle
https://knpuniversity.com/screencast/symfony-forms/the-form-type-class

```

#### **add new migrations:**
```
./bin/console doctrine:migrations:diff
./bin/console doctrine:migrations:migrate

```
