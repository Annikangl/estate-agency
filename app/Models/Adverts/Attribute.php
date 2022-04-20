<?php

namespace App\Models\Adverts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Attribute
 *
 * @package App\Models\Adverts
 * @property string $name;
 * @property string $type;
 * @property string $sort;
 * @property bool $required;
 * @property array $variants;
 * @property int $id
 * @property int $category_id

 * @mixin \Eloquent
 */

class Attribute extends Model
{
    use HasFactory;

    public const TYPE_STRING = 'string';
    public const TYPE_INTEGER = 'integer';
    public const TYPE_FLOAT = 'float';

    protected $table = 'advert_attributes';
    protected $fillable = ['name','type','sort','required','variants'];
    protected $casts = [
        'variants' => 'array'
    ];

    public $timestamps = false;

    public function typesList(): array
    {
        return [
            self::TYPE_STRING,
            self::TYPE_INTEGER,
            self::TYPE_FLOAT
        ];
    }

    public function isString(): bool
    {
        return $this->type === self::TYPE_STRING;
    }

    public function isInteger(): bool
    {
        return $this->type === self::TYPE_INTEGER;
    }

    public function isFloat(): bool
    {
        return $this->type === self::TYPE_FLOAT;
    }

    public function isNumber(): bool
    {
        return $this->isInteger() || $this->isFloat();
    }

    public function isSelect(): bool
    {
        return count($this->variants) > 0;
    }

}
