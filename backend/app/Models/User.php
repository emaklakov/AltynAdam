<?php

namespace App\Models;

use App\Traits\HasRolesAndPermissions;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

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
		$user = new User();
		$user->name = $data['name'];
		$user->phone = $data['phone'];
		$user->password = Hash::make($data['password']);
		$user->is_blocked = false;
		$user->save();

		return $user;
	}
}
