<?php

namespace App\Models;

use App\Traits\PrimaryKeyAsString;
use Illuminate\Database\Eloquent\Model;

class AccountType extends Model
{
    use PrimaryKeyAsString;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'account_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug', 'name', 'description',
    ];

    // Constants
    const TYPE_COMPANY = 'c';
    const TYPE_PERSON = 'p';
    const TYPES = [
        self::TYPE_COMPANY,
        self::TYPE_PERSON,
    ];
}
