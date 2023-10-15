@extends("admin.layouts")
@section("title", "Author")
@section("content-title", "Author List")
@section('css')
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
@endsection
@section("content")

<!-- DataTales Example -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
        @role('super-admin')
            <h6 class="m-0 font-weight-bold text-primary">List Author <span class="float-right"> <a href="{{ url("dashboard/author/create") }}" class="btn btn-success btn-sm" ><i class="fa fa-plus"> Author</i></a></span></h6>
        @endrole
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="table-author">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            @role('super-admin')
                                <th>Action</th>
                            @endrole
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($authors as $author)
                            <tr>
                                <td>{{ $author->id }}</td>
                                <td>{{ $author->name }}</td>
                                <td>
                                    @role('super-admin')
                                        <a href="{{ url('dashboard/author/' . $author['id'] . '/edit') }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i> Edit</a>
                                        <form action="{{ url('dashboard/author/' . $author['id']) }}" method="POST">
                                            @csrf
                                            @method("delete")
                                            <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</button></button>
                                        </form>
                                    @endrole
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            $('#table-author').DataTable();
        });
    </script>
@endsection