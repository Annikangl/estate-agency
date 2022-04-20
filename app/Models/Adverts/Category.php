<?php

namespace App\Models\Adverts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

/**
 * Class Category
 *
 * @package App\Models\Adverts
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int|null $parent_id
 * @property int $depth;
 * @property Category $parent;
 * @property Category[] $children;
 * @property int $_lft
 * @property int $_rgt
 */

class Category extends Model
{
    use HasFactory, NodeTrait;

    protected $table = 'advert_categories';

    public $timestamps = false;

    protected $fillable = ['name','slug','parent_id'];

    public function attrbutes()
    {
        return $this->hasMany(Attribute::class,'category_id','id');
    }

    public function parentAttributes(): array
    {
        return $this->parent ? $this->parent->allAttributes(): [];
    }

    public function allAttributes(): array
    {
        return array_merge($this->parentAttributes(), $this->attrbutes()->orderBy('sort')->getModels());
    }

}
