<?php


namespace App\Http\Controllers;


use App\Http\Requests\UserAccountUpdateRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class AccountController extends Controller
{
    public function index(){

        $user = User::where('id', Auth::id())->first();

        return view('manage-account.index', compact('user'));
    }

    public function manageAccountData(UserAccountUpdateRequest $request){

        $user = User::where('id', Auth::id())->first();

        $userData['name'] = $request->name;
        $userData['email'] = $request->email;

        if(!empty($request->password)){
            $userData['password'] = $request->password;
        }

        if (!empty($request->has('profile_picture'))) {
            $file = $request->file('profile_picture');
            $user->clearMediaCollection('user_profile_image');

            $imageName = Str::random(10) . now()->format('YmdHis') . Str::random(10) . '.' . $file->getclientoriginalextension();
            $user->addMedia($file)->usingFileName($imageName)->toMediaCollection('user_profile_image');
        }

        $user->update($userData);

        return redirect()->back()->with('success_msg', 'Account successfully updated.');
    }
}
