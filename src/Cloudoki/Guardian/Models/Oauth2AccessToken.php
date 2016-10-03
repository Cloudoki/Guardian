<?php

namespace Cloudoki\Guardian\Models;

use Cloudoki\OaStack\Models\Oauth2AccessToken as OaStackAccessToken;

class Oauth2AccessToken extends OaStackAccessToken
{
	/**
	 * User relationship
	 *
	 * @return BelongsToMany
	 */
	public function user ()
	{
		return $this->belongsTo (User::class);
	}
};