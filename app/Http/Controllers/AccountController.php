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

        $user = User::where('id', Auth::id())->with('getCompany')->first();

        return view('manage-account.index', compact('user'));
    }

    public function manageAccountData(UserAccountUpdateRequest $request){

        $user = User::where('id', Auth::id())->with('getCompany')->first();

        $userData['username'] = $request->username;
        $userData['email'] = $request->email;

        if(!empty($request->password)){
            $userData['password'] = $request->password;
        }

        if(!empty($request->has('profile_picture'))){

            $file = $request->file('profile_picture');
            $path = public_path('/assets/img/profiles');

            if(!File::isDirectory($path)){
                File::makeDirectory($path, 0777, true, true);
            }


            if($user->profile_image !== "default.png"){
                $oldImage = $path.'/'.$user->profile_image;
                if(file_exists($oldImage)){
                    File::delete($oldImage);
                }
            }

            $newImage = Str::random(10).now()->format('YmdHis').Str::random(10).'.'.$file->getclientoriginalextension();
            Image::make($file)->save($path.'/'.$newImage);

            $userData['profile_image'] = $newImage;
        }

        $user->update($userData);

        if(!empty($user->getCompany)){
            $company = Company::find($user->getCompany->id);

            $company->update([
                'name' => $request->company_name,
                'address' => $request->address,
                'state' => $request->state,
                'city' => $request->city,
                'zip' => $request->zip,
                'phone' => $request->phone
            ]);
        }

        return redirect()->back()->with('success_msg', 'Account successfully updated.');
    }
}
