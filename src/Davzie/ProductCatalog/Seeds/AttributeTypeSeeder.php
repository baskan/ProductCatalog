<?php
namespace Davzie\ProductCatalog\Seeds;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributeTypeSeeder extends Seeder {

    public function run()
    {

        $types = [
            [
                'id'            => \Davzie\ProductCatalog\Attribute\Type\Dropdown::$id,
                'name'          => 'Dropdown',
                'class'         => 'Dropdown'
            ],
            [
                'id'            => \Davzie\ProductCatalog\Attribute\Type\Text::$id,
                'name'          => 'Text',
                'class'         => 'Text'
            ],
            [
                'id'            => \Davzie\ProductCatalog\Attribute\Type\Textarea::$id,
                'name'          => 'Textarea',
                'class'         => 'Textarea'
            ]
        ];
        DB::table('attribute_types')->insert($types);
        $this->command->info('Attribute Types Table Seeded');

    }

}