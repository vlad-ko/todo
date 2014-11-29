# CakePHP 3 and jQuery "To-do" Application

[![Build Status](https://api.travis-ci.org/cakephp/app.png)](https://travis-ci.org/cakephp/app)
[![License](https://poser.pugx.org/cakephp/app/license.svg)](https://packagist.org/packages/cakephp/app)

## Installation

1. Download [Composer](http://getcomposer.org/doc/00-intro.md) or update `composer self-update`.
2. Run `php composer.phar create-project --prefer-dist -s dev cakephp/app todo`.

If Composer is installed globally, run
```bash
composer create-project --prefer-dist -s dev cakephp/app todo
```

Add the app IP/name to your local hosts file (i.e. /etc/hosts):
```bash
127.0.0.1    todo.local
```

You should now be able to visit the path to where you installed the app and see
the setup traffic lights.

## Configuration

Read and edit `config/app.php` and setup the 'Datasources' and any other
configuration relevant for your application.

Make sure all necessary plugins are loaded in `config/bootstrap.php`
