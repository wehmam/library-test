<?php

namespace App\Repository;

use App\Models\Author;
use App\Models\Book;
use App\Models\BookAuthor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BookRepository {

    public static function listBooks() {
        try {
            $books = Book::with(["authors"])
                ->orderByDesc("id")
                ->get();

            return $books;
        } catch (\Throwable $th) {
            return collect([]);
        }
    }

    public static function findBookById($id) {
        return Book::find($id);
    }

    public static function createOrUpdateAuthor($id = null) {
        try {
            $validate = self::validate($id);
            $bodyParams = request()->all();
            if(!$validate["status"]) {
                return $validate;
            }

            DB::beginTransaction();

            $book = Book::updateOrCreate(
                [
                    "id" => $id
                ],
                [
                    "title" => $bodyParams["title"],
                    "publisher" => $bodyParams["publisher"]
                ]
            );

            if($id && $book->authors->isNotEmpty()) {
                BookAuthor::where("book_id", $id)->delete();
            }

            $book->authors()->attach($bodyParams["authors"]);

            DB::commit();

            return responseCustom("Success ".(!$id ? "Add" : "Update")." Book", true);
        } catch (\Throwable $th) {
            DB::rollback();
            return responseCustom($th->getMessage(), false);
        }
    }

    public static function validate($id = null) {
        try {
            $validation = Validator::make(request()->all(), [
                "title" => "required|string|unique:books,title," . $id,
            ]);


            if($validation->fails()) {
                return responseCustom(collect($validation->errors()->all())->implode(' , '), false);
            }

            return responseCustom("Validation Success", true);
        } catch (\Throwable $th) {
            return responseCustom($th->getMessage(), false);
        }
    }

    public static function destroyBooks($id) {
        try {
            $author = self::findBookById($id);
            if(!$author) {
                return responseCustom("Book not found", false);
            }

            BookAuthor::where("book_id", $id)->delete();
            $author->delete();

            return responseCustom("Success Delete Book!", true);
        } catch (\Throwable $th) {
            return responseCustom($th->getMessage());
        }
    }
}
