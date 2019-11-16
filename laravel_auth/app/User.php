<?php
// [OAUTH] Modèle vers table user

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// [OAUTH] Lier modèle avec Passport
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    // [OAUTH] Lier modèle avec Passport
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * [ROLE] Vérifier si l'utilisateur apartient à un groupe particulier
     * @param string|array $role
     * @return bool
     */
    public function role($role=[]) {
        $role = (array)$role;
        if(empty($role)) return true;
        return in_array($this->role, $role);
    }
}
