<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    //
    public function index(Request $request) {
        // $query = Book::with(['category', 'reviews']);


        // $books = $query->paginate(12);

        $books = Book::with(['category'])->get();
        $categories = Category::orderBy('name', 'asc')->get();
        $booksStat = $this->getBooksStat();

        return view('pages.books', compact('books', 'categories', 'booksStat'));
    }

    private function getBooksStat() {
        $booksTotal = Book::count();

        $booksAvailable = DB::table('books')
            ->select(DB::raw('SUM(stock - total_borrowed) as available'))
            ->value('available');

        $booksStockCount = Book::sum('stock');

        $booksBorrowed = Book::sum('total_borrowed');

        return [
            [
                'label' => 'Total buku',
                'icon' => 'fas fa-book',
                'color' => 'cyan',
                'value' =>  $booksTotal,
            ],
            [
                'label' => 'Stock',
                'icon' => 'fas fa-layer-group',
                'color' => 'purple',
                'value' =>  $booksStockCount,
            ],
            [
                'label' => 'Tersedia',
                'icon' => 'fas fa-book-open',
                'color' => 'green',
                'value' =>  $booksAvailable,
            ],
            [
                'label' => 'Dipinjam',
                'icon' => 'fas fa-book-open-reader',
                'color' => 'orange',
                'value' =>  $booksBorrowed,
            ]
        ];
    }
}
