<?php

namespace App\Http\Controllers;

use App\Http\Requests\CardStoreRequest;
use App\Http\Requests\CardUpdateRequest;
use App\Interfaces\ChapterCardRepositoryInterface;
use App\Models\Book;
use App\Models\Chapter;
use App\Models\ChapterCard;
use App\Models\Color;
use App\Models\Outline;
use App\Models\Series;
use App\Models\User;
use Illuminate\Http\Request;

class ChapterCardController extends Controller
{
    private ChapterCardRepositoryInterface $cardRepository;

    public function __construct(ChapterCardRepositoryInterface $cardRepository)
    {
        $this->cardRepository = $cardRepository;
    }

    public function index()
    {
        if (\request()->ajax()) {
            return $this->cardRepository->getDataTable();
        }

        return view('card.index');
    }

    public function addCard()
    {
        $colors = Color::where('status', 1)->get();
        $users = User::where('status', 1)->where('id', '!=', 1)->get();

        return view('card.add', compact( 'colors', 'users'));
    }

    public function addCardData(CardStoreRequest $request)
    {
        return $this->cardRepository->createCard($request);
    }

    public function updateCard($cardId)
    {
        $card = ChapterCard::findorfail($cardId);

        if (!empty($card)) {
            $series = Series::where('user_id', $card->user_id)->where('status', 1)->get();
            $books = Book::where('series_id', $card->series_id)->where('status', 1)->get();
            $outlines = Outline::where('book_id', $card->book_id)->where('status', 1)->get();
            $colors = Color::where('status', 1)->get();
            $users = User::where('status', 1)->where('id', '!=', 1)->get();
            $chapters = Chapter::where('outline_id', $card->outline_id)->where('status', 1)->get();
            $selectedSeries = $card->series ? $card->series->id : '';
            $selectedBook = $card->book ? $card->book->id : '';
            $selectedOutline = $card->outline ? $card->outline->id : '';
            $selectedChapter = $card->chapter ? $card->chapter->id : '';

            return view('card.update', compact('card', 'series', 'books', 'outlines', 'chapters', 'selectedSeries', 'colors', 'users', 'selectedBook', 'selectedOutline', 'selectedChapter'));
        }

        abort(404);
    }

    public function updateCardData($cardId, CardUpdateRequest $request)
    {
        return $this->cardRepository->updateCard($cardId, $request);
    }

    public function getCardDetail($cardId)
    {
        $card = $this->cardRepository->getCardById($cardId);

        return view('card.detail', compact('card'));
    }

    public function changeCardStatus($cardId)
    {
        return $this->cardRepository->changeStatus($cardId);
    }

    public function deleteCard($cardId)
    {
        return $this->cardRepository->deleteCard($cardId);
    }
}
