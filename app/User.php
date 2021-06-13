<?php

namespace App;

use Alvarofpp\Masks\Traits\MaskAttributes;
use App\Models\Account;
use App\Models\AccountType;
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
        'name',
        'cpf',
        'telephone',
        'email',
        'password',
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
     * Searches the user by $value.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchBy($query, $value)
    {
        $unmaskValue = unmaskValue($value);

        // Name
        $query = $query->where('name', 'LIKE', $value . '%');
        if (!empty($unmaskValue)) {
            // CPF
            $query = $query->orWhere('cpf', 'LIKE',  $unmaskValue. '%');
            // Account.Company.CNPJ
            $query = $query->orWhereHas('accounts', function ($queryAccount) use ($value) {
                $queryAccount->where('account_type_id', AccountType::TYPE_COMPANY)
                    ->whereHas('company', function ($queryCompany) use ($value) {
                        $queryCompany->where('cnpj', 'LIKE', unmaskValue($value) . '%');
                    });
            });
        }

        return $query;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accounts()
    {
        return $this->hasMany(Account::class, 'user_id', 'id');
    }
}
