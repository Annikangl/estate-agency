<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * class Region
 *
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $parent_id
 * @property Region $parent;
 * @property Region[] $children;
 * @method Builder roots()

 */

class Region extends Model
{
    use HasFactory;

    protected $fillable = ['name','slug','parent_id'];
    public $timestamps = false;

    public function parent()
    {
        return $this->belongsTo(static::class, 'parent_id','id');
    }

    public function children()
    {
        return $this->hasMany(static::class,'parent_id','id');
    }

    public function getAddress(): string
    {
        return ($this->parent ? $this->parent->getAddress() . ', ' : '') . $this->name;
    }

    public function scopeRoots(\Illuminate\Database\Eloquent\Builder $query)
    {
        return $query->where('parent_id', null);
    }

}
