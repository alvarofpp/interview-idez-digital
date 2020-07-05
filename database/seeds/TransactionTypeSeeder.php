<?php

use App\Models\TransactionType;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TransactionTypeSeeder extends Seeder
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
                'id' => TransactionType::TYPE_BILL_PAYMENT,
                'name' => 'Pagamento de Conta',
            ],
            [
                'id' => TransactionType::TYPE_DEPOSIT,
                'name' => 'Depósito',
            ],
            [
                'id' => TransactionType::TYPE_TRANSFER,
                'name' => 'Transferência',
            ],
            [
                'id' => TransactionType::TYPE_CELL_PHONE_RECHARGE,
                'name' => 'Recarga de Celular',
            ],
            [
                'id' => TransactionType::TYPE_PURCHASE_CREDIT,
                'name' => 'Compra (Crédito)',
            ],
        ];

        $now = Carbon::now();
        foreach ($types as &$type) {
            $type['created_at'] = $now;
            $type['updated_at'] = $now;
        }

        TransactionType::insert($types);
    }
}
