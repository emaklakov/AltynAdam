<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$manageUser = new Permission();
		$manageUser->name = 'Управление пользователями';
		$manageUser->slug = 'manage-users';
		$manageUser->save();
	}
}
