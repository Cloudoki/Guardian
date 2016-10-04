<?php namespace Cloudoki\Guardian;

use Cloudoki\Guardian\Models\User;
use Cloudoki\Guardian\Models\Oauth2AccessToken;

class Guardian
{
	/**
	 *	Allowed
	 *	Is the user allowed? Valid access token,
	 *	account relation and user roles can be checked
	 *
	 *	@param	int		$accountid
	 *	@param	array	$roles
	 *	@return boolean
	 */
	public static function allowed ($accountid = null, $roles = array())
	{
		$token = config ('app.access_token', null);
		
		return !
		(
			// Was an account id even provided?
			empty($accountid) ||

			// Is the acces token valid?
			!self::validAccess ($token) ||

			// Is the user and account connected?
			($accountid && !self::accountRelation ($token, $accountid)) ||

			// Has the user the required roles for the account?
			($accountid && count($roles) && !self::hasRoles ($token, $roles))
		);
	}

	public static function allowedSuperAdmin ($token = null) {

		if (!$token)

			$token = config ('app.access_token', null);

		$user = self::user($token);

		return $user && $user->isSuperAdmin();
	}

	/**
	 *	Check
	 *	Perform allow function, throw exception if not allowed.
	 *
	 *	@param	int		$accountid
	 *	@param	array	$roles
	 *	@return void
	 *	@throws \InvalidUserException
	 */
	public static function check ($accountid = null, $roles = array())
	{

		if (self::allowedSuperAdmin())

			return;

		if (!self::allowed($accountid, $roles))

			throw new \Cloudoki\InvalidUserException ('not authorized');
	}

	public static function checkSuperAdmin ($token = null) 
	{
		if (!self::allowedSuperAdmin($token))

			throw new \Cloudoki\InvalidUserException ('not authorized');
	}

	/**
	 *	User
	 *	Show current user.
	 *
	 *	@param	string	$token
	 *	@return User
	 */
	public static function user ($token = null)
	{
		if (!$token)

			$token = config ('app.access_token', null);


		return Oauth2AccessToken::validated ($token)->first()->user;
	}
	
	/**
	 *	User id
	 *	Show current user.
	 *
	 *	@param	string	$token
	 *	@param	class	$class_override
	 *	@return User
	 */
	public static function userId ($token = null)
	{
		if (!$token)

			$token = config ('app.access_token', null);

		return Oauth2AccessToken::validated ($token)->first()->user_id;
	}

	/**
	 *	Valid access
	 *	Make sure the user has a valid access token.
	 *
	 *	@return boolean
	 */
	public static function validAccess ($token)
	{
		# Is the token provided?
		if(!$token) return false;

		# Does token exist within expiration scope?
		return (bool) Oauth2AccessToken::validated ($token)->count ();
	}

	/**
	 *	Account Relation
	 *	Make sure the user is related to the account.
	 *
	 *	the where $apk function should be a find function. Look for new Eloquent versions solving the current bug.
	 *
	 *	@return boolean
	 *	@throws \InvalidParameterException
	 */
	public static function accountRelation ($token, $id)
	{
		if (!is_int ($id))

			throw new \Cloudoki\InvalidParameterException ('an integer ID is required');

		# User contains account
		return self::user ($token)-> accounts->contains ($id);
	}

	/**
	 *	Has Roles
	 *	Make sure the user has all the required roles for the related account.
	 *
	 *  @param  int          $token    The user's access_token
	 *  @param  string|array $role     Required role(s)
	 *	@return boolean
	 *	@throws \InvalidParameterException
	 *
	 *	User vs Account rolesset as array:
	 *	return count ($roles) === count (array_intersect (self::user()->getRoles (), $roles));
	 *
	 */
	public static function hasRoles ($token, $roles)
	{
		if (is_string ($roles))

			$roles = (array) $roles;

		if(!isset ($roles) || !is_array ($roles))

			throw new \Cloudoki\InvalidParameterException ('Invalid roles container type');


		$userRoles = self::user($token)->getRoles ()->pluck ('slug')->all ();

		$requiredRoles = array_unique ($roles);
		$hasRoles = count ($requiredRoles) === count (array_intersect ($requiredRoles, $userRoles));

		return $hasRoles;
	}
}