<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$manager = new Role();
		$manager->name = 'Администратор';
		$manager->slug = 'administrator';
		$manager->save();

		$manager = new Role();
		$manager->name = 'Менеджер';
		$manager->slug = 'manager';
		$manager->save();

		$manager = new Role();
		$manager->name = 'Пользователь';
		$manager->slug = 'user';
		$manager->save();
	}
}
