<?php
namespace Cloudoki\Guardian\Models;

use Cloudoki\OaStack\Models\User as OaStackUser;

/**
 * User Model
 */
class User extends OaStackUser
{
	/**
	 * Rolegroups relationship
	 *
	 * @return hasMany
	 */
	public function rolegroups ()
	{
		return $this->belongsToMany('\Cloudoki\Guardian\Models\Rolegroup');
	}

	/**
	 * Get Rolegroups
	 * All rolegroups the user has.
	 *
	 * @param $display
	 * @return collection
	 */
	public function getRolegroups ($display)
	{
		# Get related rolegroups
		return $this->rolegroups->schema ($display);
	}

	/**
	 * Get Roles
	 * All rolegroups' roles (permissions) the user has.
	 *
	 * @param $display
	 * @return collection   A collection of unique roles the user has.
	 */
	public function getRoles ()
	{
		# Get all the roles that belong to the user's rolegroups
		# and make sure there are no duplicates.
		return $this->rolegroups()->with(['roles' => function ($query) {
			$query->groupBy('roles.id');
		}])->get()->pluck('roles')->collapse();
	}

}