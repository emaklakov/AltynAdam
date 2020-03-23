<?php

namespace App\Models;

use App\Traits\HasRolesAndPermissions;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class User extends Authenticatable
{
	use HasApiTokens, Notifiable, HasRolesAndPermissions;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'phone', 'password',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'phone_verified_at' => 'datetime',
		'created_at' => 'datetime',
		'updated_at' => 'datetime',
		'is_blocked' => 'boolean',
	];

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param array $data
	 *
	 * @return \App\Models\User
	 */
	public static function createUser(array $data)
	{
		$userRole = Role::where('slug', 'user')->first();

		$user = new User();
		$user->name = $data['name'];
		$user->phone = $data['phone'];
		$user->password = Hash::make($data['password']);
		$user->is_blocked = false;
		$user->save();
		$user->roles()->attach($userRole);

		return $user;
	}

	public static function blockUser(array $data, $user_id)
	{
		$user = User::findOrFail($user_id);
		$user->is_blocked = $data['is_blocked'];
		$user->save();

		$user->tokens()->delete();

		return $user;
	}

	public function getInfo()
	{
		return [
			'id' => $this->id,
			'name' => $this->name,
			'phone' => $this->phone,
			'is_blocked' => $this->is_blocked,
			'roles' => $this->roles,
			'permissions' => $this->permissions,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,
		];
	}
}
