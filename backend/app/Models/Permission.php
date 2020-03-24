<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'created_at', 'updated_at',
	];

	public static function createPermission(array $data)
	{
		$permission = new Permission();
		$permission->name = $data['name'];
		$permission->slug = $data['slug'];
		$permission->save();

		return $permission;
	}

	public static function updatePermission(array $data, $permission)
	{
		$is_update = false;

		if (isset($data['name']) && !empty($data['name'])) {
			$permission->name = $data['name'];
			$is_update = true;
		}

		if (isset($data['slug']) && !empty($data['slug'])) {
			$permission->slug = $data['slug'];
			$is_update = true;
		}

		if($is_update) {
			$permission->save();
		}

		return $permission;
	}

	public function roles()
	{
		return $this->belongsToMany(Role::class,'roles_permissions');
	}
}
