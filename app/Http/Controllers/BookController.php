<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller
{
    public function index()
    {

        $Books = Book::all();
        $test = Book::get()->count();
        if ($test != null) {
            return response()->json($Books, 200);
        } else {
            return response()->json("Data Not Pound", 400);
        }
    }

    public function getBook($id)
    {
        $Book = Book::find($id);
        $test = Book::get()->count();
        if ($test > 0) {
            return response()->json($Book);
        } else {
            return response()->json("Data Not Pound");
        }
    }

    public function createBook(Request $request)
    {

        $Book = Book::create($request->all());
        $test = $Book::get()->count();
        if ($test) {
            return response()->json($Book);
        } else {
            return response()->json("Data Not Pound");
        }

    }

    public function deleteBook($id)
    {
        $Book = Book::find($id);
        if (!$Book) {
            return response()->json("Books not pound data");
        }

        if (!$Book->delete()) {
            return response()->internalError("Unable to delete the post");
        }
        return $Book->delete();

        return response()->json('deleted')->message("Delete Success");
    }

    public function updateBook(Request $request, $id)
    {
        $Book = Book::find($id);
        dd($Book);
        if($Book){
            return response()->json("Books not pound data");
        }
        $Book = new Book();
        $Book->title = $request->input('title');
        $Book->author = $request->input('author');
        $Book->isbn = $request->input('isbn');
        $Book->save();

        return response()->json($Book);
    }

    /**
     * Upload and move portfolio images
     *
     * @return Response
     */
    public function upload()
    {

        $user = Auth::user();
        $creative = Creative::where('user_id', $user->id)->firstOrFail();

        $file = Input::file('filedata');

        $destinationPath = 'uploads/workimages';
        $filename = Auth::user()->slug . str_random(6);
        $extension = $file->getClientOriginalExtension();
        $size = $file->getSize();
        $fullName = $filename . '.' . $extension;
        $upload_success = $file->move($destinationPath, $fullName);


        if ($upload_success) {
            return Response::json(['name' => $fullName, 'size' => $size], 200);
        } else {
            return Response::json('error', 400);
        }
    }
}
