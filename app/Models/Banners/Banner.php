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

    const STATUS_DRAFT = 'Черновик';

    public static function scopeForUser(?\App\Models\User $user)
    {
    }

    public static function formatsList(): array
    {
        return [];
    }

    public function canBeChanged(): bool
    {
    }

    public function sendToModeration()
    {
    }

    public function cancelModeration()
    {

    }

    public function pay(\Carbon\Carbon $now)
    {

    }

    public function moderate()
    {

    }

    public function reject()
    {

    }

    public function order($cost)
    {

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
}
