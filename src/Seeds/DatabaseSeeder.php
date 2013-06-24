<?php
namespace Davzie\ProductCatalog\Seeds;
use Illuminate\Database\Seeder;
use Eloquent;

class DatabaseSeeder extends Seeder {

    public function run()
    {
        Eloquent::unguard();

        $this->call('Davzie\ProductCatalog\Seeds\UserTable');
        $this->command->info('All Tables Seeded');
    }

}