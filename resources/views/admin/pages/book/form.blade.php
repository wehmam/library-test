@extends("admin.layouts")
@section('title', 'Book Form')
@section('content-title', 'Book Author')
@section('css')
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--single {
            height: 38px !important;
            /* padding: 10px 16px; */
            padding: 5px;
            /* font-size: 18px;  */
            line-height: 1.33;
            border-radius: 6px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            top: 75% !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 26px !important;
        }

        .select2-container--default .select2-selection--single {
            border: 1px solid #CCC !important;
            box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.075) inset;
            transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
        }

        .delete-price-type-range-field {
            color: red;
        }
        .delete-price-type-range-field:hover {
            color: red;
            cursor: pointer;
        }

    </style>
@endsection
@section('content')

    <!-- DataTales Example -->
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Book Author</h6>
            </div>
            <div class="card-body">
                <form action="{{ Request::segment(3) == "create" ? url("dashboard/book") : url("dashboard/book/" . $book->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(Request::segment(3) != "create")
                        <input type="hidden" name="_method" value="PUT">
                    @endif
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="title">Title</label>
                            <input type="text" name="title" value="{{ $book->title ?? old("title") }}" class="form-control" id="title" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="publisher">Publisher</label>
                            <input type="text" name="publisher" value="{{ $book->publisher ?? old("publisher") }}" class="form-control" id="publisher" required>
                        </div>
                    </div>

                    <div class="form-row mb-2">
                        <label for="authors">Authors<a href="{{ url("dashboard/author/create") }}" target="_blank"  class="btn btn-success btn-sm ml-2" ><i class="fa fa-plus"></i></a></label>
                        <select name="authors[]" id="authors" class="form-control" multiple="multiple" required>
                            @foreach ($authors as $author)
                                @if(isset($book))
                                    <option value="{{ $author->id }}"
                                        @foreach ($book->authors as $a)
                                            {{ $a->name == $author->name ? "selected" : "" }}
                                        @endforeach>
                                        {{ $author->name }}
                                    </option>
                                @else
                                    <option value="{{ $author->id }}">{{ $author->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#authors').select2();
    });
</script>
@endsection
