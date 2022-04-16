<?php

namespace App\Models\Adverts\Advert;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Value
 *
 * @package App\Models\Adverts\Advert
 * @property int $attribute_id;
 * @property string $value;
 * @property int $advert_id
 * @property int $attribute_id
 * @property string $value
 * @method static \Illuminate\Database\Eloquent\Builder|Value newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Value newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Value query()
 * @method static \Illuminate\Database\Eloquent\Builder|Value whereAdvertId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Value whereAttributeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Value whereValue($value)
 * @mixin \Eloquent
 */

class Value extends Model
{
    use HasFactory;

    protected $table = 'advert_advert_values';
    protected $fillable = ['attribute_id','value'];
    public $timestamps = false;

}
