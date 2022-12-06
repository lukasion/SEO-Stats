<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => Hash::make('test'),
        ]);

        \App\Models\Customer::insert([
            ['name' => 'AutoECU'],
            ['name' => 'Taxnet']
        ]);

        \App\Models\Phrase::insert([
            [
                'name' => 'testowa fraza1',
                'customer_id' => 1,
            ],[
                'name' => 'testowa fraza2',
                'customer_id' => 1,
            ],[
                'name' => 'testowa fraza3',
                'customer_id' => 1,
            ], [
                'name' => 'testowa fraza1',
                'customer_id' => 2,
            ],[
                'name' => 'testowa fraza2',
                'customer_id' => 2,
            ],[
                'name' => 'testowa fraza3',
                'customer_id' => 2,
            ], [
                'name' => 'testowa fraza1',
                'customer_id' => 2,
            ],[
                'name' => 'testowa fraza2',
                'customer_id' => 2,
            ],[
                'name' => 'testowa fraza3',
                'customer_id' => 2,
            ],
        ]);

        \App\Models\PhrasePosition::insert([
            [
                'phrase_id'  => 1,
                'position'   => json_encode([
                    '1' => 78, '2' => 75, '3' => 75, '4' => 75, '5' => 75, '6' => 78, '7' => 75, '8' => 75, '9' => 75, '10' => 75, '11' => 78, '12' => 75, '13' => 75, '14' => 75, '15' => 75, '16' => 78, '17' => 75, '18' => 75, '19' => 75, '20' => 75, '21' => 75, '22' => 78, '23' => 75, '24' => 75, '25' => 75, '26' => 75, '27' => 78, '28' => 75, '29' => 75, '30' => 75, '31' => 25,
                ]),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ], [
                'phrase_id'  => 2,
                'position'   => json_encode([
                    '1' => 78, '2' => 75, '3' => 75, '4' => 75, '5' => 75, '6' => 78, '7' => 75, '8' => 75, '9' => 75, '10' => 75, '11' => 78, '12' => 75, '13' => 75, '14' => 75, '15' => 75, '16' => 78, '17' => 75, '18' => 75, '19' => 75, '20' => 75, '21' => 75, '22' => 78, '23' => 75, '24' => 75, '25' => 75, '26' => 75, '27' => 78, '28' => 75, '29' => 75, '30' => 75, '31' => 25,
                ]),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        ]);
    }
}
