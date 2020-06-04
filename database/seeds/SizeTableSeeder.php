<?php

use App\Entities\Size;
use Illuminate\Database\Seeder;

class SizeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $size = new Size();
        $size->name = 'Personal';
        $size->description = 'Personal';
        $size->save();

        $size = new Size();
        $size->name = 'Mediana';
        $size->description = 'Mediana';
        $size->save();

        $size = new Size();
        $size->name = 'Familiar';
        $size->description = 'Familiar';
        $size->save();
    }
}
