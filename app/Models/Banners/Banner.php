<?php

namespace App\Models\Banners;

use App\Models\Adverts\Category;
use App\Models\Region;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Banner
 * @package App\Models\Banners
 * @mixin Builder
 * @property int $id
 * @property int $user_id
 * @property int $category_id
 * @property int $region_id
 * @property int $views
 * @property int $limit
 * @property int $clicks
 * @property int $cost
 * @property string $url
 * @property string $format
 * @property string $file
 * @property string $status
 * @property Carbon $published_at
 *
 * @property Region|null $region
 * @property Category $category
 *
 * @method Builder active()
 * @method Builder forUser(User $user)
 */
class Banner extends Model
{
    use HasFactory;

    public const STATUS_DRAFT = 'Черновик';
    public const STATUS_MODERATION = 'На модерации';
    public const STATUS_MODERATED = 'Одобрен';
    public const STATUS_ORDERED = 'Заказан на оплату';
    public const STATUS_ACTIVE = 'Активен';
    public const STATUS_CLOSED = 'Закрыт';

    protected $table = 'banner_banners';

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'published_at' => 'datetime'
    ];

    public static function statusesList(): array
    {
        return [
            self::STATUS_DRAFT => 'Черновик',
            self::STATUS_MODERATION => 'На модерации',
            self::STATUS_MODERATED => 'Одобрен',
            self::STATUS_ORDERED => 'Оплачен',
            self::STATUS_ACTIVE => 'Активирован',
            self::STATUS_CLOSED => 'Закрыт'
        ];
    }

    public static function formatsList(): array
    {
        return [
            '240x400'
        ];
    }

    public function view(): void
    {
        $this->assetIsActive();
        $this->increment('views');

        if ($this->views >= $this->limit) {
            $this->status = self::STATUS_CLOSED;
        }

        $this->save();
    }

    public function click(): void
    {
        $this->assetIsActive();
        $this->increment('clicks');
        $this->save();
    }

    public function sendToModeration(): void
    {
        if (!$this->isDraft()) {
            throw new \DomainException('Это не черновик');
        }

        $this->update([
            'status' => self::STATUS_MODERATION
        ]);
    }

    public function cancelModeration(): void
    {
        if (!$this->isOnModeration()) {
            throw new \DomainException('Баннер уже на проверке');
        }

        $this->update([
            'status' => self::STATUS_DRAFT
        ]);
    }

    public function moderate(): void
    {
        if (!$this->isOnModeration()) {
            throw new \DomainException('Баннер уже на проверке');
        }

        $this->update([
            'status' => self::STATUS_MODERATED
        ]);
    }

    public function reject($reason): void
    {
        $this->update([
            'status' => self::STATUS_DRAFT,
            'reject_reason' => $reason
        ]);
    }

    public function order(int $cost): void
    {
        if (!$this->isModerated()) {
            throw new \DomainException('Баннер еще не одобрен');
        }

        $this->update([
            'cost' => $cost,
            'status' => self::STATUS_ORDERED
        ]);
    }

    public function pay(\Carbon\Carbon $date)
    {
        if (!$this->isOrdered()) {
            throw new \DomainException('Баннер еще не одобрен');
        }

        $this->update([
            'published_at' => $date,
            'status' => self::STATUS_ACTIVE
        ]);
    }

    public function getWidth(): int
    {
        return explode('x', $this->format)[0];
    }

    public function getHeight(): int
    {
        return explode('x', $this->format)[1];
    }

    public function canBeChanged(): bool
    {
        return $this->isDraft();
    }

    public function canBeRemoved(): bool
    {
        return $this->isActive();
    }

    public function isDraft(): bool
    {
        return self::STATUS_DRAFT === $this->status;
    }

    public function isOrdered(): bool
    {
        return $this->status === self::STATUS_ORDERED;
    }

    public function isActive(): bool
    {
        return self::STATUS_ACTIVE === $this->status;
    }

    public function isOnModeration(): bool
    {
        return self::STATUS_MODERATION === $this->status;
    }

    public function isModerated(): bool
    {
        return self::STATUS_MODERATED === $this->status;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class,'region_id','id');
    }

    public static function scopeForUser(Builder $query, User $user): Builder
    {
        return $query->where('user_id', $user->id);
    }

    public static function scopeActive(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    private function assetIsActive(): void
    {
        if (!$this->isActive()) {
            throw new \DomainException('Banner is not active.');
        }
    }
}
