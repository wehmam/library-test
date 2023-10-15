<?php

namespace App\Http\Controllers\Admin\Book;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Author;
use App\Repository\BookRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index() {
        $books = BookRepository::listBooks();
        return view("admin.pages.book.index", compact("books"));
    }

    public function create() {
        $authors = Author::get();
        return view("admin.pages.book.form", compact("authors"));
    }

    public function edit(Book $book)
    {
        $authors = Author::get();
        return view("admin.pages.book.form", compact("book", "authors"));
    }

    public function store() {
        $response = BookRepository::createOrUpdateAuthor();
        if(!$response["status"]) {
            alertNotify(false, $response["data"]);
            return back()->withInput();
        }

        alertNotify(true, $response["data"]);
        return redirect(url("dashboard/book"));
    }

    public function update($id) {
        $response = BookRepository::createOrUpdateAuthor($id);
        if(!$response["status"]) {
            alertNotify(false, $response["data"]);
            return back()->withInput();
        }

        alertNotify(true, $response["data"]);
        return redirect(url("dashboard/book"));
    }

    public function destroy($id) {
        $response = BookRepository::destroyBooks($id);
        if(!$response["status"]) {
            alertNotify(false, $response["data"]);
            return back();
        }

        alertNotify(true, $response["data"]);
        return back();
    }

    public function listBooks(Request $request) {
        $authors = BookRepository::listBooks();
        $superAdmin = Auth::user()->hasRole("super-admin");
        $arrayData = collect([]);

        $authors->each(function($q) use($arrayData, $superAdmin) {
            $arrayData->push([
                $q->id ?? "",
                $q->title ?? "",
                $q->publisher,
                $q->authors()->pluck("name")->implode(", "),
                $superAdmin ? '<a href="'.url('dashboard/book/' . $q['id'] . '/edit').'" class="btn btn-sm btn-info"><i class="fa fa-edit"></i> Edit</a>' .
                '<form action="'.url('dashboard/book/' . $q['id']).'" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="'.csrf_token().'">
                    <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</button></button>
                </form>'
                : "-"
            ]);
        });

        return response()->json([
            "draw"              => $request->get("draw"),
            "recordsTotal"      => $authors->total(),
            "recordsFiltered"   => $authors->total(),
            "data"              => $arrayData->toArray()
        ]);
    }
}
