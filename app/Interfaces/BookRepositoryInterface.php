<?php

namespace App\Interfaces;

interface BookRepositoryInterface
{
    public function getAllBooks();

    public function getBookById($bookId);

    public function createBook($bookDetails);

    public function updateBook($bookId, $bookDetails);

    public function changeStatus($bookId);

    public function deleteBook($bookId);
}
