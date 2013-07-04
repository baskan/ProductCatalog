<?php
namespace Davzie\ProductCatalog\Seeds;
use Illuminate\Database\Seeder;
use Eloquent;

class DatabaseSeeder extends Seeder {

    public function run()
    {
        Eloquent::unguard();

        $this->call('Davzie\ProductCatalog\Seeds\UserTable');
        $this->call('Davzie\ProductCatalog\Seeds\AttributeTypeSeeder');
        $this->command->info('All Tables Seeded');
    }

}