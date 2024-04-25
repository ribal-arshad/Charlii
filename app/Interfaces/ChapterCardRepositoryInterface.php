<?php

namespace App\Interfaces;

interface ChapterCardRepositoryInterface
{
    public function getAllCards();

    public function getCardById($cardId);

    public function createCard($cardDetails);

    public function updateCard($cardId, $cardDetails);

    public function changeStatus($cardId);

    public function deleteCard($cardId);
}
