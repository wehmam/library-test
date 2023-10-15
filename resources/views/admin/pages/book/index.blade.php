@extends("admin.layouts")
@section("title", "Books")
@section("content-title", "Book List")
@section('css')
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
@endsection
@section("content")

<!-- DataTales Example -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
        @role('super-admin')
            <h6 class="m-0 font-weight-bold text-primary">List Books <span class="float-right"> <a href="{{ url("dashboard/book/create") }}" class="btn btn-success btn-sm" ><i class="fa fa-plus"> Book</i></a></span></h6>
        @endrole
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="table-books">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Title</th>
                            <th>Publisher</th>
                            <th>Author Names</th>
                            @role('super-admin')
                                <th>Action</th>
                            @endrole
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($books as $book)
                            <tr>
                                <td>{{ $book->id }}</td>
                                <td>{{ $book->title }}</td>
                                <td>{{ $book->publisher }}</td>
                                <td>{{ $book->authors()->pluck("name")->implode(", ") }}</td>
                                @role('super-admin')
                                    <td>
                                        <a href="{{ url('dashboard/book/' . $book['id'] . '/edit') }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i> Edit</a>
                                        <form action="{{ url('dashboard/book/' . $book['id']) }}" method="POST">
                                            @csrf
                                            @method("delete")
                                            <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</button></button>
                                        </form>
                                    </td>
                                @endrole
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
        $('#table-books').DataTable();
    });
</script>
@endsection
