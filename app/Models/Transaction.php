<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transactions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'value',
        'transaction_type_id', 'account_from_id', 'account_to_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transaction_type()
    {
        return $this->belongsTo(TransactionType::class, 'transaction_type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account_from()
    {
        return $this->belongsTo(Account::class, 'account_from_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account_to()
    {
        return $this->belongsTo(Account::class, 'account_to_id');
    }
}
