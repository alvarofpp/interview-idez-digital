<?php

use \App\Models\AccountType;
use \Carbon\Carbon;
use Illuminate\Database\Seeder;

class AccountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'id' => AccountType::TYPE_COMPANY,
                'slug' => 'company',
                'name' => 'Empresarial',
                'description' => 'Conta empresarial.',
            ],
            [
                'id' => AccountType::TYPE_PERSON,
                'slug' => 'person',
                'name' => 'Pessoal',
                'description' => 'Conta pessoa.',
            ],
        ];

        $now = Carbon::now();
        foreach ($types as &$type) {
            $type['created_at'] = $now;
            $type['updated_at'] = $now;
        }

        AccountType::insert($types);
    }
}
