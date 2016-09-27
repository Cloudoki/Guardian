<?php

namespace Cloudoki\Guardian\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

use Cloudoki\Guardian\Guardian;
use Cloudoki\Guardian\Models\User;
use Cloudoki\Guardian\Models\Role;

class RoleController extends Controller
{

	/**
	 *  Index
	 *  Find all Role.
	 *
	 *  @param  $payload
	 *  @return boolean
	**/
	public function index($payload)
	{

		# Validate
		$userId = Guardian::userId();
		$user = User::find((int) $userId);
		$account = $user->accounts->first();
		Guardian::check ($account->getId(), 'role:view');

		# return roles
		return Role::orderBy('id')
			->get()
			->map(function ($role) use ($payload) {
				return $role->schema($payload->display);
			}
		);
	}

}
