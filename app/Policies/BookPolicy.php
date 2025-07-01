<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Book;

class BookPolicy
{
    /**
     * Create a new policy instance.
     */
    // public function __construct()
    // {
    //     //
    // }

    public function viewAny(User $user) {
        return true;
    }

    public function view(?User $user, Book $book) {
        return true;
    }

    public function create(User $user) {
        return $user->canManageBooks();
    }

    public function update(User $user, Book $book) {
        return $user->canManageBooks();
    }

    public function delete(User $user, Book $book) {
        return $user->canManageBooks();
    }

    public function borrow(User $user, Book $book) {
        return $user->isAnggota() && $book->isAvailable();
    }

}
