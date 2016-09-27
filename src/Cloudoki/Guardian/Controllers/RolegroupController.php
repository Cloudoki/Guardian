<?php

namespace Cloudoki\Guardian\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

use Cloudoki\Guardian\Guardian;
use Cloudoki\Guardian\Models\User;
use Cloudoki\Guardian\Models\Rolegroup;
use Cloudoki\Guardian\Models\Role;

class RolegroupController extends Controller
{

	/**
	 *  Index
	 *  Find all Rolegroups.
	 *
	 *  @param  $payload
	 *  @return boolean
	**/
	public function index($payload)
	{

		\Log::info('payload: ' . print_r($payload, true));
		# Validate
		$userId = Guardian::userId();
		$user = User::find((int) $userId);
		$account = $user->accounts->first();
		Guardian::check ($account->getId(), 'rolegroup:view');

		# Ids Filter
		if (isset ($payload->ids))

			$list = Rolegroup::find(explode(',', $payload->ids));

		# Search Filter
		else if (isset ($payload->q))

			$list = Rolegroup::where(
				function ($q) use ($payload)
				{
					foreach (['name', 'description'] as $field)

						$q->orWhere($field, 'like', '%' . str_replace (' ', '', $payload->q) .'%');

				}
			)->get();

		# Retrieve rolegroups
		else

			$list = Rolegroup::orderBy('id')->get();

		# return all (account) users
		return $list->map(function ($rolegroup) use ($payload) {
			// \Log::info('role group at index: ' . print_r($rolegroup, true));
			return $rolegroup->schema($payload->display);
		});
	}

	/**
	 *  Get
	 *  Find a single Rolegroup.
	 *
	 *  @param  $payload
	 *  @return boolean
	**/
	public function show($payload)
	{
		# Validate
		$userId = Guardian::userId();
		$user = User::find((int) $userId);
		$account = $user->accounts->first();
		Guardian::check ($account->getId(), 'rolegroup:view');

		$rolegroup = Rolegroup::find($payload->id);

		if (!$rolegroup)

			throw new ModelNotFoundException();

		return $rolegroup->schema($payload->display);
	}


	/**
	 *  Post
	 *  Create a rolegroup.
	 *
	 *  @param $payload
	 *  @return object
	**/
	public static function store ($payload)
	{
		# Validate
		$userId = Guardian::userId();
		$user = User::find((int) $userId);
		$account = $user->accounts->first();
		Guardian::check ($account->getId(), 'rolegroup:write');

		DB::beginTransaction();

 		try {
			# Save input (name and description)
			$rolegroup = new Rolegroup;
			$rolegroup->schemaUpdate((array) $payload);

			# TODO save list of roles (permissions)
			$roles = Role::find($payload->roles);
			$rolegroup->roles()->attach($roles);
		} catch(\Exception $e) {
			DB::rollback();
			throw $e;
		}

		DB::commit();

		# Return created rolegroup with respective roles (permissions)
		return $rolegroup->schema($payload->display);
	}

	/**
	 *  Patch
	 *  Update an existing rolegroup.
	 *
	 *  @param $payload
	 *  @return object
	**/
	public static function update ($payload)
	{
		# Validate
		$userId = Guardian::userId();
		$user = User::find((int) $userId);
		$account = $user->accounts->first();
		Guardian::check ($account->getId(), 'rolegroup:write');

		DB::beginTransaction();

 		try {
			# Save input (name and description)
			$rolegroup = Rolegroup::find($payload->id);

			if (!$rolegroup)

				throw new ModelNotFoundException();

			$rolegroup->schemaUpdate((array) $payload);

			# TODO save list of roles (permissions)
			$roles = Role::find($payload->roles);
			$rolegroup->roles()->detach();
			$rolegroup->roles()->attach($roles);
		} catch(\Exception $e) {
			DB::rollback();
			throw $e;
		}

		DB::commit();

		# Return created rolegroup with respective roles (permissions)
		return $rolegroup->schema($payload->display);
	}

	/**
	 *  Destroy
	 *  Soft delete a Rolegroup.
	 *
	 *  @param  $payload
	 *  @return boolean
	**/
	public function destroy($payload)
	{

		$userId = Guardian::userId();
		$user = User::find((int) $userId);
		$account = $user->accounts->first();
		Guardian::check ($account->getId(), 'rolegroup:delete');

		$rolegroup = Rolegroup::find($payload->id);

		if (!$rolegroup) {
			throw new ModelNotFoundException();
		}

		# Soft Delete
		$rolegroup = Rolegroup::destroy($payload->id);

		return true;
	}

}
