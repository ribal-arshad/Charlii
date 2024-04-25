<?php

namespace App\Interfaces;

interface ChapterRepositoryInterface
{
    public function getAllChapters();

    public function getChapterById($chapterId);

    public function createChapter($chapterDetails);

    public function updateChapter($chapterId, $chapterDetails);

    public function changeStatus($chapterId);

    public function deleteChapter($chapterId);
}
