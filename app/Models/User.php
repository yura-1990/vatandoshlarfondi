<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\StatusEnum;
use App\Models\Userdata\CompatriotExpert;
use App\Models\Userdata\UserProfile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

/**
 * Class User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property StatusEnum $status
 */
class User extends \TCG\Voyager\Models\User implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, HasFactory;

    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'oauth_id',
        'oauth_provider',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }

    public function compatriotExpert(): HasOne
    {
        return $this->hasOne(CompatriotExpert::class);
    }

    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class, 'user_id', 'id');
    }
}
