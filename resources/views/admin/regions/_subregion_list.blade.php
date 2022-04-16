<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th scope="col">№ п/п</th>
        <th scope="col">Регион</th>
        <th scope="col">Slug</th>
        <th scope="col"> Parent</th>
    </tr>
    </thead>
    <tbody>
    @foreach($regions as $region)
        <tr>
            <td>{{ $region->id }}</td>
            <td><a href="{{ route('admin.regions.show', $region) }}">{{ $region->name }}</a></td>
            <td>{{ $region->slug }}</td>
            <td>{{ $region->parent ? $region->parent->name : '' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
