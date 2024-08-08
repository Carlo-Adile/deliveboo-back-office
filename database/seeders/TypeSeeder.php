<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Type;
use Illuminate\Support\Str;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['Cinese', 'Sushi', 'Italiano', 'Pizzeria', 'Fast Food', 'Steak House', 'Asiatico', 'Indiano'];

        foreach ($types as $typeData) {
            $type = new Type();
            $type->name = $typeData;
            $type->slug = Str::slug($typeData, '-');
            $type->save();
        }
    }
}
