<?php

namespace App\Http\Controllers\Admin\Author;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Repository\AuthorRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests\AuthorRequest;
use Illuminate\Support\Facades\Auth;

class AuthorController extends Controller
{
    public function __construct()
    {
        // $this->middleware('your-middleware')->only(['store', 'update', 'destroy']);
    }

    public function index() {
        $authors = AuthorRepository::listAuthors();
        return view("admin.pages.author.index", compact("authors"));
    }

    public function create() {
        return view("admin.pages.author.form");
    }

    public function edit(Author $author)
    {
        return view("admin.pages.author.form", compact('author'));
    }

    public function store() {
        $response = AuthorRepository::createOrUpdateAuthor();
        if(!$response["status"]) {
            alertNotify(false, $response["data"]);
            return back();
        }

        alertNotify(true, $response["data"]);
        return redirect(url("dashboard/author"));
    }

    public function update($id) {
        $response = AuthorRepository::createOrUpdateAuthor($id);
        if(!$response["status"]) {
            alertNotify(false, $response["data"]);
            return back();
        }

        alertNotify(true, $response["data"]);
        return redirect(url("dashboard/author"));
    }

    public function destroy($id) {
        $response = AuthorRepository::destroyAuthors($id);
        if(!$response["status"]) {
            alertNotify(false, $response["data"]);
            return back();
        }

        alertNotify(true, $response["data"]);
        return back();
    }

    public function listAuthors(Request $request) {
        $authors = Author::paginate(10);
        $superAdmin = Auth::user()->hasRole("super-admin");
        $arrayData = collect([]);

        $authors->each(function($q) use($arrayData, $superAdmin) {
            $arrayData->push([
                $q->id ?? "",
                $q->name ?? "",
                $superAdmin ? '<a href="'.url('dashboard/author/' . $q['id'] . '/edit').'" class="btn btn-sm btn-info"><i class="fa fa-edit"></i> Edit</a>' .
                '<form action="'.url('dashboard/author/' . $q['id']).'" method="POST">
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
