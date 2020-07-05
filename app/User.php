<?php

namespace App;

use Alvarofpp\Masks\Traits\MaskAttributes;
use App\Models\Account;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use MaskAttributes, HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'cpf', 'telephone',
        'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 15;

    /**
     * The attributes that should be masked.
     *
     * @var array
     */
    protected $masks = [
        'cpf' => '###.###.###-##',
        'telephone' => [
            8 => '####-####',
            9 => '#####-####',
            10 => '(##) ####-####',
            11 => '(##) #####-####',
            12 => '(###) #####-####',
            13 => '+## (##) #####-####',
            14 => '+## (###) #####-####',
        ],
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accounts()
    {
        return $this->hasMany(Account::class, 'user_id', 'id');
    }
}
