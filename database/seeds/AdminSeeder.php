<?php

use App\models\RoleUser;
use App\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'fullname' => 'admin',
            'email' => 'admin@app.com',
            'password' => bcrypt("admin"),
            'id_role' => RoleUser::where('name','Admin')->first()->id,
            'flag' => '1'
        ]);
    }
}
