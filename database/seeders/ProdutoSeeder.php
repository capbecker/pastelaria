<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class ProdutoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('produtos')->insert([
            'nome' => 'Pastel',
            'preco' => 5.99,
            'foto' => 'pastel-paralax.png'
        ]);

        DB::table('produtos')->insert([
            'nome' => 'Combo pasteis 3',
            'preco' => 15.00,
            'foto' => 'pastel-img.png'
        ]);
    }
}
