<?php

/*
|--------------------------------------------------------------------------
| Guardian Routes
|--------------------------------------------------------------------------
|
| All the Guardian Endpoints are defined here.
| You may want to include or copy them to your general ./app/routes.php file.
|
*/

# Authentication required.
Route::group(array ('prefix'=> 'guardian'), function ($app)
{
	# Role
	$app->resource (
		'roles',
		'\Cloudoki\Guardian\Controllers\RoleViewController',
		['only' => ['index']]
	);

	# Rolegroup
	$app->resource (
		'rolegroups',
		'\Cloudoki\Guardian\Controllers\RolegroupViewController',
		['only' => ['index', 'show', 'store', 'update', 'destroy']]
	);
});