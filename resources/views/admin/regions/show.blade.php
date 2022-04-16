@extends('layouts.app')

@section('content')
    <div class="container">
        @include('admin.regions._nav')

        <div class="d-flex flex-row mb-3">
            <a href="{{ route('admin.regions.edit', $region) }}" class="btn btn-primary mr-1">Изменить</a>

            <form action="{{ route('admin.regions.destroy', $region) }}" method="post" class="mr-1">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">Удалить</button>
            </form>
        </div>

        <table class="table table-bordered table-striped">
            <tbody>
            <tr>
                <th scope="row">№ п/п.</th>
                <td>{{ $region->id }}</td>
            </tr>
            <tr>
                <th>Регион</th>
                <td>{{ $region->name }}</td>
            </tr>
            <tr>
                <th>Parent</th>
                <td>{{ $region->slug }}</td>
            </tr>
            </tbody>
        </table>

        @include('admin.regions._subregion_list', ['regions' => $region->children])
    </div>
@endsection
