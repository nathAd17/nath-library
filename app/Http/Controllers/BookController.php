<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreBookRequest;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    //
    public function index(Request $request)
    {
        // $query = Book::with(['category', 'reviews']);


        // $books = $query->paginate(12);

        $books = Book::with(['category'])->get();
        $books->map(function ($book) {
            $book->cover_url = Storage::url($book->cover_image);
            return $book;
        });

        $categories = Category::orderBy('name', 'asc')->get();
        $booksStat = $this->getBooksStat();
        $user = [
            'id' => Auth::id(),
            'role' => Auth::user()->role
        ];

        return view('pages.books', compact('books', 'categories', 'booksStat', 'user'));
    }

    private function getBooksStat()
    {
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

    public function store(Request $request)
    {
        try {

            // $this->authorize('create', Book::class);

            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'author' => 'required|string|max:255',
                'publisher' => 'required|string|max:255',
                'year' => 'required|integer|min:1000|max:' . date('Y'),
                'isbn' => 'nullable|string|unique:books,isbn',
                'description' => 'required|string',
                'category_id' => 'required|exists:categories,id',
                'stock' => 'required|integer|min:1',
                'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);
            // $validatedData = $request->validated();
            if ($request->hasFile('cover_image')) {
                $validatedData['cover_image'] = $request->file('cover_image')->store('book-covers', 'public');
            }

            $books = Book::create($validatedData);

            return response()->json([
                'message' => 'Buku berhasil ditambahkan',
                'book' => $books
            ], 201); // Set status code 201 untuk created

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Data tidak valid',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error saat menambah buku:', ['error' => $e->getMessage()]);

            return response()->json([
                'message' => 'Terjadi kesalahan saat menambah buku'
            ], 500);
        }

        // (opsional) redirect kalau bukan ajax
        // return redirect()->back()->with('success', 'Buku berhasil ditambahkan');
    }
}
