<?php

namespace App\Repository;

use App\Models\Author;
use App\Models\BookAuthor;
use Illuminate\Support\Facades\Validator;

class AuthorRepository {
    public static function listAuthors() {
        try {
            $authors = Author::orderByDesc("id")
                ->get();

            return $authors;
        } catch (\Throwable $th) {
            return collect([]);
        }
    }

    public static function findAuthorById($id) {
        return Author::find($id);
    }

    public static function createOrUpdateAuthor($id = null) {
        try {
            $validate = self::validate($id);
            if(!$validate["status"]) {
                return $validate;
            }

            Author::updateOrCreate(
                [
                    "id" => $id
                ],
                [
                    "name" => request()->get('name')
                ]
            );

            return responseCustom("Success ".(!$id ? "Add" : "Update")." Author", true);
        } catch (\Throwable $th) {
            return responseCustom($th->getMessage(), false);
        }
    }

    public static function destroyAuthors($id) {
        try {
            $author = self::findAuthorById($id);
            if(!$author) {
                return responseCustom("author not found", false);
            }

            $bookAuthor = BookAuthor::where("author_id", $id)
                ->count();

            if($bookAuthor > 0) {
                return responseCustom("Cannot delete author, becaue author has book", false);
            }

            $author->delete();

            return responseCustom("Success Delete Author!", true);
        } catch (\Throwable $th) {
            return responseCustom($th->getMessage());
        }
    }

    public static function validate($id = null) {
        try {
            $validation = Validator::make(request()->all(), [
                "name" => "required|string|unique:authors,name," . $id
            ]);


            if($validation->fails()) {
                return responseCustom(collect($validation->errors()->all())->implode(' , '), false);
            }

            return responseCustom("Validation Success", true);
        } catch (\Throwable $th) {
            return responseCustom($th->getMessage(), false);
        }
    }
}
