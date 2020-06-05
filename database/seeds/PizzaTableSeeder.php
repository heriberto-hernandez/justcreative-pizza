<?php

use App\Entities\Pizza;
use Illuminate\Database\Seeder;

class PizzaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pizza = new Pizza();
        $pizza->name = 'Pepperoni Personal';
        $pizza->price = '50'; 
        $pizza->sizes_id = '1';
        $pizza->save();

        $pizza = new Pizza();
         $pizza->name = 'Pepperoni Mediana';
        $pizza->price = '80'; 
        $pizza->sizes_id = '2';
        $pizza->save();

        $pizza = new Pizza();
        $pizza->name = 'Pepperoni Familiar';
        $pizza->price = '120'; 
        $pizza->sizes_id = '3';
        $pizza->save();
    }
}
