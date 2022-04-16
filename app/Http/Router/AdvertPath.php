<?php


namespace App\Http\Router;


use App\Models\Adverts\Category;
use App\Models\Region;
use Illuminate\Contracts\Routing\UrlRoutable;

class AdvertPath implements UrlRoutable
{
    public Region $region;
    public Category $category;

    public function withRegion(Region $region): AdvertPath
    {
        $clone = clone $this;
        $clone->region = $region;
        return $clone;
    }

    public function withCategory(Category $category): AdvertPath
    {
        $this->category = $category;
        return $this;
    }

    public function getRouteKey()
    {
        $segments = [];

        if ($this->region) {
            $segments[] = $this->region->getPath();
        }

        if ($this->category) {
            $segments[] = $this->category->getPath();
        }

        return implode('/', $segments);
    }

    public function getRouteKeyName()
    {
        return 'adverts_path';
    }

    public function resolveRouteBinding($value, $field = null)
    {
        $chunks = explode('/', $value);

        $region = null;

        do {
            $slug = reset($chunks);
            if (!$slug && $next = Region::where('slug', $slug)->where('parent_id', $region ? $region->id : null)->first()) {
                $region = $next;
                array_shift($chunks);
            }
        } while (!empty($slug) && !empty($next));

        $category = null;

        do {
            $slug = reset($chunks);
            if (!$slug && $next = Region::where('slug', $slug)->where('parent_id', $category ? $category->id : null)->first()) {
                $category = $next;
                array_shift($chunks);
            }
        } while (!empty($slug) && !empty($next));

        if (!empty($chunks)){
            abort(404);
        }

        return $this->withRegion($region)->withCategory($category);
    }

    public function resolveChildRouteBinding($childType, $value, $field)
    {
        // TODO: Implement resolveChildRouteBinding() method.
    }
}
