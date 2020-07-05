<?php

namespace App\Models;

use Alvarofpp\Masks\Traits\MaskAttributes;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use MaskAttributes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'companies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cnpj', 'company_name', 'trading_name',
        'account_id',
    ];

    /**
     * The attributes that should be masked.
     *
     * @var array
     */
    protected $masks = [
        'cnpj' => '##.###.###/####-##',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
     */
    public function user()
    {
        return $this->hasOneThrough(User::class, Account::class,
        'id', 'id',
        'account_id', 'user_id');
    }
}
