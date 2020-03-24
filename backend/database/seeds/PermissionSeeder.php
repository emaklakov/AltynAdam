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
		$manageUser = Permission::where(['slug' => 'manage-roles'])->first();

		if(!$manageUser) {
			$manageUser = new Permission();
			$manageUser->name = 'Управление ролями';
			$manageUser->slug = 'manage-roles';
			$manageUser->save();
		}

		$manageUser = Permission::where(['slug' => 'manage-users'])->first();

		if(!$manageUser) {
			$manageUser = new Permission();
			$manageUser->name = 'Управление пользователями';
			$manageUser->slug = 'manage-users';
			$manageUser->save();
		}

		$manageOvoschi = Permission::where(['slug' => 'manage-ovoschi'])->first();

		if(!$manageOvoschi) {
			$manageOvoschi = new Permission();
			$manageOvoschi->name = 'Управление Овощным';
			$manageOvoschi->slug = 'manage-ovoschi';
			$manageOvoschi->save();
		}
	}
}
