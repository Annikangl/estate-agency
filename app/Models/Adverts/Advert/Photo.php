<?php

namespace App\Models\Adverts\Advert;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Adverts\Advert\Photo
 *
 * @property int $id
 * @property int $advert_id
 * @property string $file
 * @method static \Illuminate\Database\Eloquent\Builder|Photo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Photo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Photo query()
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereAdvertId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereId($value)
 * @mixin \Eloquent
 */
class Photo extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['file'];
    protected $table = 'advert_advert_photos';
}
