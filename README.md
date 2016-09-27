# Guardian

As extension to the **[Oauth2 Stack](http://blog.cloudoki.com/oauth2-stack/)**, Guardian provides internal Authorisation scopes for Laravel.

This package is usable in multiple Laravel versions. Right now, however, the Guardian package is only tested in Laravel 4.2 with Eloquent.

####Dependencies
**Oauth2-Stack** - Guardian uses the **Account** and **User** models next to the **Oauth2Verifier** class.

**Except-io-nal** - The Cloudoki PHP Exception extensions are used to throw manageable errors when authorisations are not valid.

## Install Laravel 5.2 MQ
Add our package as requirement in your composer file.
```
$ nano composer.json
```
```
"require": {
    "laravel/framework": "5.2.*",
    "cloudoki/guardian": "dev-master"
    ...
```
You might want to run an update. If something goes wrong, change your `minimum-stability` to `dev` in the `composer.json` file, for now.
```
$ composer update
```


The package is now installed in the project `vendor` folder. You'll need to register the package provider in your app config file next.
Since Laravel 5, the Illuminate\Form is no longer part of the core pack, so you should register it as well.
```
$ nano config/app.php
```
```
	'providers' => [
		...
		Collective\Html\HtmlServiceProvider::class,
		Cloudoki\OaStack\OaStackServiceProvider::class,
		Cloudoki\Guardian\GuardianServiceProvider::class
    ],

	'aliases' => [
		...
        'Form'		=> Collective\Html\FormFacade::class,
        'Guardian'	=> Cloudoki\Guardian\GuardianFacade::class,
        'HTML'		=> Collective\Html\HtmlFacade::class,
    ],
```

### DB Migration
Of course, your backend workers need db access for validation. It goes something like this:


### DB Seeds

In order to create the roles required by the Guardian package itself, run the following command from the root path of the app that uses this package.

```
php artisan db:seed --class="Database\Seeds\GuardianRolesSeeder"
```

## Usage

#### Oauth2 Stack

Please [dig into](http://blog.cloudoki.com/oauth2-stack/) the Oauth2 Stack documentation before implementing Guardian.

#### Access Token

The **access token** is requested as `Input` parameter, in respect to the Oauth2 Stack and **MQ alignment**. In a production level API request however, the access token should ALWAYS be placed in the Authorisation header of the request.

#### Management REST Endpoints

The Guardian package provides REST API endpoints to view and manage Rolegroups and Roles. Detailed documentation in [this wiki page](https://github.com/Cloudoki/Guardian/wiki/Management-Endpoints).
