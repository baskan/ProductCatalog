<?php
namespace Davzie\ProductCatalog\Seeds;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

class UserTable extends Seeder {

    public function run()
    {

        $types = [
            [
                'email'         => Config::get('ProductCatalog::setup.email'),
                'first_name'    => Config::get('ProductCatalog::setup.first-name'),
                'last_name'     => Config::get('ProductCatalog::setup.last-name'),
                'is_admin'      => true,
                'password'      => Hash::make( Config::get('ProductCatalog::setup.password') ),
            ]
        ];
        DB::table('users')->insert($types);
        $this->command->info('User Table Seeded');

    }

}