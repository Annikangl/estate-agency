<?php

namespace App\Http\Controllers\Admin\Advert;

use App\Http\Controllers\Controller;
use App\Http\Requests\Adverts\AttributesRequest;
use App\Models\Adverts\Attribute;
use App\Models\Adverts\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AttributesController extends Controller
{

    public function create(Category $category)
    {
        $types = Attribute::typesList();

        return view('admin.adverts.categories.attributes.create', compact('types','category'));
    }

    public function store(AttributesRequest $request, Category $category)
    {
        $attribute = $category->attrbutes()->create([
            'name' => $request['name'],
            'type' => $request['type'],
            'required' => (bool)$request['required'],
            'variants' => array_map('trim', preg_split('#[\r\n]+#', $request['variants'])),
            'sort' => $request['sort']
        ]);

        return redirect()->route('admin.advert.categories.attributes.show', [$category, $attribute]);
    }

    public function show(Category $category, Attribute $attribute)
    {
        return view('admin.adverts.categories.attributes.show',
            compact('category', 'attribute'));
    }

    public function edit(Category $category, Attribute $attribute)
    {
        $types = Attribute::typesList();

        return view('admin.adverts.edit',
            compact('category', 'attribute','types'));
    }

    public function update(AttributesRequest $request, Category $category, Attribute $attribute)
    {
        $category->attrbutes()->findOrFail($attribute->id)->update([
            'name' => $request['name'],
            'type' => $request['type'],
            'required' => (bool)$request['required'],
            'variants' => array_map('tring', preg_split('#[\r\n]+#', $request['variants'])),
            'sort' => $request['sort']
        ]);

        return redirect()->route('admin.Advert.categories.show', $category);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.Advert.categories.index');
    }

}
