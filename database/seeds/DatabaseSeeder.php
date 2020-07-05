<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Types
        $this->call(AccountTypeSeeder::class);
        $this->call(TransactionTypeSeeder::class);

        if (app()->environment() !== 'production') {
            $this->call(DevelopmentSeeder::class);
        }
    }
}
