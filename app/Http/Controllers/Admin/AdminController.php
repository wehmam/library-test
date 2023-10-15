<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard() {
        $books = Book::count();
        $authors = Author::count();
        $users = User::count();
        return view("admin.pages.dashboard", compact("books", "authors", "users"));
    }
}
