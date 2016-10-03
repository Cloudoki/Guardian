<?php 
namespace Cloudoki\Guardian\Models;

use Cloudoki\Guardian\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 *	Role Model	
 *	Add the namespace if you want to extend your custom Role model with this one.	
 */

class Rolegroup extends BaseModel
{
	use SoftDeletes;

	/**
	 * The model type.
	 *
	 * @const string
	 */
	const type = 'rolegroup';

	/**
	 * Fillables
	 * define which attributes are mass assignable (for security)
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'description'];
	
    protected $dates = ['deleted_at'];
    	
	/**
	 * Roles relationship
	 *
	 * @return BelongsToMany
	 */
	public function roles ()
	{
		return $this->belongsToMany ('Cloudoki\Guardian\Models\Role');
	}

	/**
	 * Get role name
	 *
	 * @return	string
	 */
	public function getName ()
	{
		return $this->name;
	}

	/**
	 * Set role name
	 *
	 * @param	string	$name
	 */
	public function setName ($name)
	{
		$this->name = $name;
		
		return $this;
	}

	/**
	 * Get role description
	 *
	 * @return	string
	 */
	public function getDescription ()
	{
		return $this->description;
	}

	/**
	 * Set role description
	 *
	 * @param	string	$description
	 */
	public function setDescription ($description)
	{
		$this->description = $description;
		
		return $this;
	}
	
	/**
	 * Get role limits
	 *
	 * @return	string
	 */
	public function getLimits ()
	{
		return $this->limits;
	}

	/**
	 * Set role limits
	 *
	 * @param	string	$limits
	 */
	public function setLimits ($limits)
	{
		$this->limits = $limits;
		
		return $this;
	}

	/**
	 * Get the roles (permissions) associated
	 * to this rolegroup.
	 *
	 * @param	string	$limits
	 */
	public function getRoles ($display)
	{
		# Get related roles
		return $this->roles->map(function ($role) use ($display) {
			return $role->schema ($display);
		});
	}

}
