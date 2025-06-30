<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    //
    public function index() {
        $books = Book::with(['category'])->get();
        $categories = Category::orderBy('name', 'asc')->get();
        return view('pages.books', compact(['books', 'categories']));
    }
}
