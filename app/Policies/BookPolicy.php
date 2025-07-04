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
        return in_array($user->role, ['admin', 'anggota', 'pustakawan']);
    }

    public function view(?User $user, Book $book) {
        return true;
    }

    public function create(User $user) {
        return $user->canManageBooks();
    }

    public function update(User $user, Book $books) {
        return $user->canManageBooks();
    }

    public function delete(User $user, Book $book) {
        return $user->role === 'admin';
    }

    public function borrow(User $user, Book $book) {
        return $user->isAnggota() && $book->isAvailable();
    }

}
