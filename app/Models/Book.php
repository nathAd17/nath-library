<?php

namespace App\Models;

use App\Models\TransactionItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'publisher',
        'year',
        'isbn',
        'description',
        'category_id',
        'cover_image',
        'stock',
        'total_borrowed',
        'qr_code',
    ];

    protected $casts = [
        'year' => 'integer',
        'stock' => 'integer',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(BookReview::class);
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function (Builder $query) use ($search) {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
        });
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    // Helper methods
    public function isAvailable()
    {
        return $this->stock > 0;
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function totalReviews()
    {
        return $this->reviews()->count();
    }

    public function generateQRCode()
    {
        // Generate QR code for book
        return "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode(route('books.show', $this->id));
    }

}
