<?php

namespace App\Models;

use App\Models\Adverts\Advert\Advert;
use App\Models\User\Network;
use Carbon\Carbon;
use http\Exception\InvalidArgumentException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 *
 * @mixin Builder;
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property bool $phone_verified
 * @property string $password
 * @property string $verify_code
 * @property string $phone_verify_token
 * @property Carbon $phone_verify_token_expired
 * @property string $status
 * @property string $role

 */

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const STATUS_WAIT = 'wait';
    public const STATUS_ACTIVE = 'active';

    public const ROLE_ADMIN = 'admin';
    public const ROLE_USER = 'user';
    public const ROLE_MODERATOR = 'moderator';

    protected $fillable = [
        'name',
        'last_name',
        'email',
        'phone',
        'phone_verified',
        'phone_verify_token_expired',
        'password',
        'status',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified' => 'boolean',
        'phone_verify_token_expired' => 'datetime',
    ];

    public static function roleList(): array
    {
        return [
            self::ROLE_USER => 'user',
            self::ROLE_ADMIN => 'admin',
            self::ROLE_MODERATOR,
        ];
    }

    public static function statusList(): array
    {
        return [
            self::STATUS_WAIT => 'wait',
            self::STATUS_ACTIVE => 'active',
        ];
    }

    public static function register(string $name, string $email, string $password)
    {
        return static::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'verify_code' => \Str::uuid(),
            'status' => self::STATUS_WAIT,
            'role' => self::ROLE_USER
        ]);
    }

    public static function registerByNetwork(string $network, string $identity): self
    {
        $user = static::create([
            'name' => $identity,
            'email' => null,
            'password' => null,
            'verify_code' => null,
            'status' => self::STATUS_ACTIVE,
            'role' => self::ROLE_USER
        ]);

        $user->networks()->create([
            'network' => $network,
            'identity' => $identity
        ]);

        return $user;
    }

    public static function new($name, $email): self
    {
        return static::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt(Str::random()),
            'status' => self::STATUS_ACTIVE
        ]);
    }

    public function isWait(): bool
    {
        return $this->status === self::STATUS_WAIT;
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function verify(): void
    {
        if (!$this->isWait()) {
            throw new \DomainException('User is already verified');
        }

        $this->update([
            'status' => self::STATUS_ACTIVE,
            'verify_token' => null
        ]);
    }

    public function changeRole($role): void
    {
        if (!in_array($role, self::roleList(),true)) {
            throw new InvalidArgumentException('Undefined role ' . $role);
        }
        if ($this->role === $role) {
            throw new \DomainException('Role already assigned');
        }

        $this->update([
            'role' => $role
        ]);
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isModerator(): bool
    {
        return $this->role === self::ROLE_MODERATOR;
    }

    public function isPhoneVerified(): bool
    {
        return $this->phone_verified;
    }

    // Обнуляет верификацию при изменении номера телефона
    public function unverifyPhone(): void
    {
        $this->phone_verified = false;
        $this->phone_verify_token = null;
        $this->phone_verify_token_expired = null;

        $this->save();
    }

    // Запрос на подтверждение телефона
    public function requestPhoneVerification(Carbon $now): string
    {
        if (empty($this->phone)) {
            throw new \DomainException('Phone number is empty');
        }

        if (!empty($this->phone_verify_token) && $this->phone_verify_token_expired &&
            $this->phone_verify_token_expired->gt($now)) {
            throw new \DomainException('Token is already requested');
        }

        $this->phone_verified = false;
        $this->phone_verify_token = (string)random_int(10000,99999);
        $this->phone_verify_token_expired = $now->copy()->addSeconds(300);

        $this->saveOrFail();

        return $this->phone_verify_token;
    }

//    Верификация номера телефона
    public function verifyPhone($token, Carbon $now): void
    {
        if ($token !== $this->phone_verify_token) {
            throw new \DomainException('Incorrect verify token');
        }
        if ($this->phone_verify_token_expired->lt($now)){
            throw new \DomainException('Token is expired');
        }

        $this->phone_verified = true;
        $this->phone_verify_token = null;
        $this->phone_verify_token_expired = null;

        $this->saveOrFail();
    }

//    Проверка заполнен ли профиль
    public function hasFilledProfile(): bool
    {
        if (empty($this->name) || empty($this->last_name) || !$this->isPhoneVerified()) {
            return false;
        }

        return true;
    }

    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(Advert::class, 'advert_favorites','user_id','advert_id');
    }

    public function networks(): BelongsToMany
    {
        return $this->belongsToMany(Network::class, 'user_id', 'id');
    }

    public function addToFavorite($advertId)
    {
        if ($this->hasInFavorite($advertId)) {
            throw new \DomainException('Это объявление уже добавлено в Избранное');
        }
        $this->favorites()->attach($advertId);
    }

    public function hasInFavorite($id)
    {
        return $this->favorites()->where('id', $id)->exists();
    }

    public function removeFromFavorites($advertId)
    {
        $this->favorites()->detach($advertId);
    }

    public function scropebyNetwork(Builder $query, $network, $identity)
    {
        return $query->whereHas('networks', function (Builder $query) use ($network, $identity) {
           $query->where('network', $network)->where('identity', $identity);
        });
    }
}
