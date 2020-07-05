<?php

namespace App\Models;

use App\Traits\PrimaryKeyAsString;
use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{
    use PrimaryKeyAsString;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transaction_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    // Constants
    const TYPE_BILL_PAYMENT = 'bp';
    const TYPE_DEPOSIT = 'd';
    const TYPE_TRANSFER = 't';
    const TYPE_CELL_PHONE_RECHARGE = 'cpr';
    const TYPE_PURCHASE_CREDIT = 'pc';
    const TYPES = [
        self::TYPE_BILL_PAYMENT,
        self::TYPE_DEPOSIT,
        self::TYPE_TRANSFER,
        self::TYPE_CELL_PHONE_RECHARGE,
        self::TYPE_PURCHASE_CREDIT,
    ];
}
