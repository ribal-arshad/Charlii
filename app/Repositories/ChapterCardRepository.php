<?php

namespace App\Repositories;

use App\Interfaces\ChapterCardRepositoryInterface;
use App\Models\ChapterCard;
use Yajra\DataTables\Facades\DataTables;

class ChapterCardRepository implements ChapterCardRepositoryInterface
{
    public function getAllCards()
    {
        return ChapterCard::get();
    }

    public function getCardById($cardId)
    {
        return ChapterCard::findOrFail($cardId);
    }

    public function deleteCard($cardId)
    {
        $card = $this->getCardById($cardId);
        if (!empty($card)) {
            $card->delete();

            return redirect()->back()->with('success_msg', 'Chapter Card successfully deleted.');
        }

        abort(404);
    }

    public function createCard($cardDetails)
    {
        $card = ChapterCard::create([
            'user_id' => $cardDetails->user_id,
            'color_id' => $cardDetails->color_id,
            'series_id' => $cardDetails->series_id,
            'book_id' => $cardDetails->book_id,
            'outline_id' => $cardDetails->outline_id,
            'chapter_id' => $cardDetails->chapter_id,
            'card_title' => $cardDetails->card_title,
            'card_description' => $cardDetails->card_description,
            'status' => $cardDetails->status,
        ]);

        return redirect()->route('manage.cards')->with('success_msg', 'Chapter successfully added.');
    }

    public function updateCard($cardId, $cardDetails)
    {
        $card = ChapterCard::findOrFail($cardId);

        if(!empty($card)){
            $card->update([
                'user_id' => $cardDetails['user_id'],
                'color_id' => $cardDetails['color_id'],
                'series_id' => $cardDetails['series_id'],
                'book_id' => $cardDetails['book_id'],
                'outline_id' => $cardDetails['outline_id'],
                'chapter_id' => $cardDetails['chapter_id'],
                'card_title' => $cardDetails['card_title'],
                'card_description' => $cardDetails['card_description'],
                'status' => $cardDetails['status'],
            ]);

            return redirect()->route('manage.cards')->with('success_msg', 'Chapter Card successfully updated.');
        }

        return redirect()->back()->withInput()->with('error_msg', 'Chapter Card not found.');
    }

    public function getDataTable(){

        $query = ChapterCard::query();

        return Datatables::of($query)
            ->filter(function ($instance) {
                $search = request('search')['value'];
                if (!empty($search)) {
                    $instance->where(function($w) use ($search){
                        if(strtolower($search) === "active"){
                            $w->orWhere('status', 1);
                        }elseif(strtolower($search) === "inactive"){
                            $w->orWhere('status', 0);
                        }
                    });
                }
            })
            ->addColumn('user_name', function ($obj) {
                return $obj->user->name;
            })
            ->addColumn('series_name', function ($obj) {
                return $obj->series ? $obj->series->series_name : '';
            })
            ->addColumn('book_name', function ($obj) {
                return $obj->book ? $obj->book->book_name : '';
            })
            ->addColumn('outline_name', function ($obj) {
                return $obj->outline ? $obj->outline->outline_name : '';
            })
            ->addColumn('chapter_name', function ($obj) {
                return $obj->chapter ? $obj->chapter->chapter_name : '';
            })
            ->addColumn('color', function ($obj) {
                return $obj->color ? '<span class="color-block"><span style="background-color: ' . $obj->color->color_code . '"></span>' . $obj->color->color . '</span>' : '';
            })
            ->editColumn('status', function ($obj) {
                $isChecked = "";
                if($obj->status){
                    $isChecked = "checked";
                }

                if (auth()->user()->can('card.status.update')) {
                    $switchBtn = '<label class="switch switch-success">
                                            <input type="checkbox" class="switch-input" ' . $isChecked . ' onclick="changeStatus(`' . route('card.change.status', $obj->id) . '`)" />
                                            <span class="switch-toggle-slider">
                                              <span class="switch-on">
                                                <i class="bx bx-check"></i>
                                              </span>
                                              <span class="switch-off">
                                                <i class="bx bx-x"></i>
                                              </span>
                                            </span>
                                        </label>';
                } else {
                    $switchBtn = $obj->status === 1 ? 'Active' : 'Inactive';
                }

                return $switchBtn;
            })
            ->addColumn('action', function ($obj) {
                $buttons = '<div class="btn-group">';
                if(auth()->user()->can('card.detail')) {
                    $buttons .= '<a class="btn btn-primary btn-sm redirect-btn" href="' . route('card.detail', $obj->id) . '">Show</a>';
                }
                if(auth()->user()->can('card.edit')) {
                    $buttons .= '<a class="btn btn-success btn-sm redirect-btn" href="' . route('card.update', $obj->id) . '">Edit</a>';
                }
                if(auth()->user()->can('card.delete')) {
                    $buttons .= '<a class="btn btn-danger btn-sm redirect-btn" href="' . route('card.delete', $obj->id) . '">Delete</a>';
                }

                $buttons .= '</div>';

                return $buttons;
            })
                ->rawColumns(['user_name', 'series_name', 'book_name', 'outline_name', 'chapter_name', 'color', 'status', 'action'])->make(true);
    }

    public function changeStatus($cardId)
    {
        $msg = 'Something went wrong.';
        $code = 400;
        $card = $this->getCardById($cardId);

        if (!empty($card)) {
            $card->update([
                'status' => !$card->status
            ]);
            $msg = "Chapter Card status successfully changed.";
            $code = 200;
        }

        return response()->json(['msg' => $msg], $code);
    }
}
