<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\CreateRequest;
use App\Http\Requests\Admin\Users\UpdateRequest;
use App\Models\Region;
use App\Models\User;
use App\Http\Services\Auth\RegisterService;
use Illuminate\Http\Request;


class RegionController extends Controller
{
    public function index(Request $request)
    {
        $regions = Region::where('parent_id', null)->orderBy('name')->get();

        return view('admin.regions.index',
            compact('regions'));
    }

    public function create(Request $request)
    {
        $parent = null;

        if ($request->get('parent')) {
            $parent = Region::findOrFail($request->get('parent'));
        }

        return view('admin.regions.create', compact('parent'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:regions,name,NULL,id,parent_id,' . ($request['parent'] ?: 'NULL'),
            'slug' => 'required|string|max:255|unique:regions,slug,NULL,id,parent_id,' . ($request['parent'] ?: 'NULL'),
            'parent' => 'optional|exists:regions,id',
        ]);

        $region = Region::create([
            'name' => $request['name'],
            'slug' => $request['slug'],
            'parent_id' => $request['parent']
        ]);

        return redirect()->route('admin.regions.show', $region);
    }

    public function show(Region $region)
    {
        $regions = $region->children()->orderBy('name')->get();

        return view('admin.regions.show',
            compact('region','regions'));
    }

    public function edit(Region $region)
    {
        return view('admin.regions.edit', compact('region'));
    }

    public function update(Request $request, Region $region)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:regions,name' . $region->id . ',id,parent_id' .$region->parent_id,
            'slug' => 'required|string|max:255|unique:regions,slug' . $region->id . ',id,parent_id' .$region->parent_id,
        ]);

        $region->update($request->only(['name', 'slug']));

        return redirect()->route('admin.regions.show', $region);
    }

    public function destroy(Region $region)
    {
        $region->delete();

        return redirect()->route('admin.regions.index');
    }

}
