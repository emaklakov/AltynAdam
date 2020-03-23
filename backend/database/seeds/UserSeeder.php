<?php

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$manager = Role::where('slug', 'manager')->first();
		$manageUsers = Permission::where('slug','manage-users')->first();

		$user1 = new User();
		$user1->name = 'Mike Thomas';
		$user1->phone = '+77020000000';
		$user1->password = bcrypt('secret');
		$user1->save();
		$user1->roles()->attach($manager);
		$user1->permissions()->attach($manageUsers);
	}
}
