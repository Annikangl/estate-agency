<?php

namespace App\Http\Controllers\Admin\Advert;

use App\Http\Controllers\Controller;
use App\Models\Adverts\Attribute;
use App\Models\Adverts\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::defaultOrder()->withDepth()->get();

        return view('admin.adverts.categories.index', compact('categories'));
    }

    public function create()
    {
        $parents = Category::defaultOrder()->withDepth()->get();

        return view('admin.adverts.categories.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' =>  'required|string|max:255',
            'slug' => 'required|string|max:255',
            'parent' => 'nullable|integer|exists:advert_categories,id'
        ]);

        $category = Category::create([
            'name' => $request['name'],
            'slug' => $request['slug'],
            'parent_id' => $request['parent']
        ]);

        return redirect()->route('admin.advert.categories.show', $category);
    }

    public function show(Category $category)
    {
        $attributes = $category->attrbutes()->orderBy('sort')->get();

        return view('admin.adverts.categories.show',
            compact('category','attributes'));
    }

    public function edit(Category $category)
    {
        $parents = Category::defaultOrder()->withDepth()->get();

        return view('admin.adverts.categories..edit',
            compact('category', 'parents'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' =>  'required|string|max:255',
            'slug' => 'required|string|max:255',
            'parent' => 'nullable|integer|exists:advert_categories,id'
        ]);

        $category->update([
            'name' => $request['name'],
            'slug' => $request['slug'],
            'parent' => $request['parent']
        ]);

        return redirect()->route('admin.advert.categories.show', $category);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.advert.categories.index');
    }

    public function first(Category $category)
    {
        if ($first = $category->siblings()->defaultOrder()->first()) {
            $category->insertBeforeNode($first);
        }

        return redirect()->route('admin.advert.categories.index');
    }

    public function up(Category $category)
    {
        $category->up();

        return redirect()->route('admin.advert.categories.index');
    }

    public function down(Category $category)
    {
        $category->down();

        return redirect()->route('admin.advert.categories.index');
    }

    public function last(Category $category)
    {
        if ($first = $category->siblings()->defaultOrder('desc')->first()) {
            $category->insertAfterNode($first);
        }

        return redirect()->route('admin.advert.categories.index');
    }
}
