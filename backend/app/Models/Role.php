<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'created_at', 'updated_at',
	];

	public static function createRole(array $data)
	{
		$role = new Role();
		$role->name = $data['name'];
		$role->slug = $data['slug'];
		$role->save();

		return $role;
	}

	public static function updateRole(array $data, $role)
	{
		$is_update = false;

		if (isset($data['name']) && !empty($data['name'])) {
			$role->name = $data['name'];
			$is_update = true;
		}

		if (isset($data['slug']) && !empty($data['slug'])) {
			$role->slug = $data['slug'];
			$is_update = true;
		}

		if (isset($data['permissions']) && !empty($data['permissions'])) {
			$permissions = Permission::whereIn('id', $data['permissions'])->get();

			$role->permissions()->detach();
			$role->permissions()->saveMany($permissions);

			$is_update = true;
		}

		if($is_update) {
			$role->save();
		}

		return $role;
	}

	public function permissions()
	{
		return $this->belongsToMany(Permission::class,'roles_permissions');
	}
}
