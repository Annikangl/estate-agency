<?php

namespace App\Models\Adverts\Advert;

use App\Models\Adverts\Category;
use App\Models\Region;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Advert
 *
 * @package App\Models\Adverts
 * @mixin Builder;
 * @property int $id;
 * @property int $user_id;
 * @property int $category_id;
 * @property int $region_id;
 * @property string $title;
 * @property string $content;
 * @property int $price;
 * @property string $address;
 * @property string $status;
 * @property string $reject_reason;
 * @property Carbon $created_at;
 * @property Carbon $updated_at;
 * @property Carbon $published_at;
 * @property Carbon $expired_at;
 * @property Category $category
 * @property Region $region
 * @property User $user
 * @property Value[] $values
 * @method Builder ForUser()
 * @method Builder ForCategory()
 * @method Builder ForRegion()
 * @method Builder active()
 * @method Builder FavotireForUser()

 */
class Advert extends Model
{
    use HasFactory;

    public const STATUS_DRAFT = 'draft';
    public const STATUS_MODERATION = 'moderation';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_CLOSED = 'closed';

    protected $table = 'advert_adverts';

    protected $guarded = ['id'];

    protected $casts = [
        'published_at' => 'datetime',
        'expired_at' => 'datetime',
    ];

    public static function statusesList(): array
    {
        return [
            'active' => self::STATUS_ACTIVE,
            'draft' => self::STATUS_DRAFT,
            'closed' => self::STATUS_CLOSED,
            'moderation' => self::STATUS_MODERATION
        ];
    }

    public function sendToModeration(): void
    {
        if (!$this->isDraft()) {
            throw new \DomainException('Данное объявление нельзя повторно отправить на модерацию!');
        }
        if (!$this->photos()->count()) {
            throw new \DomainException('Загрузите фото');
        }

        $this->update([
            'status' => self::STATUS_MODERATION
        ]);
    }

    public function moderate(Carbon $date): void
    {
        if ($this->status === self::STATUS_MODERATION) {
            throw new \DomainException('Объявление нельзя повторно отправить на модерацию!');
        }

        $this->update([
            'published_at' => $date,
            'expired_at' => $date->copy()->addDays(14),
            'status' => self::STATUS_ACTIVE
        ]);
    }

    public function reject(string $reason): void
    {
        $this->update([
            'status' => self::STATUS_DRAFT,
            'reject_reason' => $reason
        ]);
    }

    public function expirre(): void
    {
        $this->update([
            'status' => self::STATUS_CLOSED,
            'expired_at' => Carbon::now()
        ]);
    }

    public function isDraft(): bool
    {
        return $this->status === self::STATUS_DRAFT;
    }

    public function isModeration(): bool
    {
        return $this->status === self::STATUS_MODERATION;
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class,'region_id','id');
    }

    public function values()
    {
        return $this->hasMany(Value::class,'advert_id','id');
    }

    public function photos()
    {
        return $this->hasMany(Photo::class,'advert_id','id');
    }

    public function getValue(int $id)
    {
        foreach ($this->values as $value) {
            if ($value->attribute_id === $id) {
                return $value->value;
            }
        }
        return null;
    }

    public function scopeForUser(Builder $query, User $user): Builder
    {
        return $query->where('user_id', $user->id);
    }

    public function scopeForCategory(Builder $query, Category $category): Builder
    {
        return $query->whereIn('category_id', array_merge(
            [$category->id],
            $category->descendants()->pluck('id')->toArray()
        ));
    }

    public function scopeForRegion(Builder $query, Region $region): Builder
    {
        $ids = [$region->id];
        $childrenIds = $ids;

        while ($childrenIds = Region::where(['parent_id' => $childrenIds])->pluck('id')->toArray()) {
            $ids = array_merge($ids, $childrenIds);
        }

        return $query->where('region_id',$ids);
    }

    public static function scopeActive(Builder $query): Builder
    {
        return $query->where('status',self::STATUS_ACTIVE);
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class,  'advert_favorites', 'advert_id', 'user_id');
    }

    public function scopeFavoredByUser(Builder $query, User $user)
    {
        return $query->whereHas('favorites', function(Builder $query) use ($user) {
            $query->where('user_id', $user->id);
        });
    }
}
