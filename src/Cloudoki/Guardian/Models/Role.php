<?php
namespace Cloudoki\Guardian\Models;

class Role extends BaseModel
{

    /**
     * The model type.
     *
     * @const string
     */
    const type = 'role';

    protected $fillable = ['slug','description'];
    
    /**
	 * Since we're using an existing db and Eloquent expects us to have (by default)
	 * the updated_at, created_at columns, we need to disable the automatic timestamp updates
	 * on this model
	 *
	 * @var bool
	 */
	public $timestamps = false;

    /**
	 * Rolegroups relationship
	 *
	 * @return BelongsToMany
	 */
	public function rolegroups ()
	{
		return $this->belongsToMany ('Cloudoki\Guardian\Models\Rolegroup');
	}

    /**
	 * Get role slug
	 *
	 * @return	string
	 */
	public function getSlug ()
	{
		return $this->slug;
	}

	/**
	 * Set role slug
	 *
	 * @param	string	$slug
	 */
	public function setSlug ($slug)
	{
		$this->slug = $slug;
		
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

}
