<?php


namespace App\Repositories;


use App\Interfaces\ManageUserRepositoryInterface;
use App\Models\User;
use App\Notifications\UserWelcome;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class ManageUserRepository implements ManageUserRepositoryInterface
{
    public function getAllUser()
    {
        return User::all();
    }

    public function getUserById($userId)
    {
        return User::findOrFail($userId);
    }

    public function deleteUser($userId)
    {
        $user = User::where('id', $userId)->first();
        if(!empty($user)){
            $user->syncRoles([]);
            $user->delete();

            return redirect()->back()->with('success_msg', 'User successfully deleted.');
        }
        abort(404);
    }

    public function createUser($req)
    {
        $role = Role::where('id', $req->role)->first();

        if(empty($role)){
            return redirect()->back()->withInput()->with('error_msg', 'Role is invalid.');
        }

        $user = User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => $req->password,
            'email_verified_at' => now(),
            'user_type' => 0,
        ]);

        if (!empty($req->has('profile_picture'))) {
            $file = $req->file('profile_picture');

            $imageName = Str::random(10) . now()->format('YmdHis') . Str::random(10) . '.' . $file->getclientoriginalextension();
            $user->addMedia($file)->usingFileName($imageName)->toMediaCollection('user_profile_image');
        }

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);

        $credentials = '<br /><strong>Username:</strong> ' . $req->email . '<br /><strong>Password:</strong> ' . $req->password;

        $user->notify((new UserWelcome($credentials))->delay(now()->addSeconds(5)));

        return redirect()->route('manage.users')->with('success_msg', 'User successfully added.');
    }

    public function updateUser($userId, $req)
    {
        $user = User::where('id', $userId)->first();

        if(!empty($user)){
            $userData['name'] = $req->name;
            $userData['email'] = $req->email;
            if(!empty($req->password)){
                $userData['password'] = $req->password;
            }

            if (!empty($req->has('profile_picture'))) {
                $file = $req->file('profile_picture');
                $user->clearMediaCollection('user_profile_image');

                $imageName = Str::random(10) . now()->format('YmdHis') . Str::random(10) . '.' . $file->getclientoriginalextension();
                $user->addMedia($file)->usingFileName($imageName)->toMediaCollection('user_profile_image');
            }

            $user->update($userData);

            if(!empty($req->password)){
                $credentials = '<br /><strong>Username:</strong> ' . $req->email . '<br /><strong>New Password:</strong> ' . $req->password;

                $user->notify((new UserWelcome($credentials))->delay(now()->addSeconds(5)));
            }

            return redirect()->route('manage.users')->with('success_msg', 'User successfully updated.');
        }

        return redirect()->back()->withInput()->with('error_msg', 'User not found.');
    }

    public function getDataTable(){

        $query = User::where('id', '!=', Auth::id());

        return Datatables::of($query)
            ->filter(function ($instance) {
                $search = request('search')['value'];
                if (!empty($search)) {
                    $instance->where(function($w) use ($search){
                        $w->orWhere('name', 'LIKE', "%$search%")
                            ->orWhere('email', 'LIKE', "%$search%");

                        if(strtolower($search) === "Not Verified"){
                            $w->orWhereNull('email_verified_at');
                        }elseif(strtolower($search) === "Verified"){
                            $w->orWhereNotNull('email_verified_at');
                        }

                    });
                }
            })
            ->editColumn('is_verified', function ($obj){
                return !empty($obj->email_verified_at) ? $obj->email_verified_at->format('m-d-Y') : "Not Verified";
            })
            ->editColumn('status', function ($obj) {
                $isChecked = "";
                if(!empty($obj->status)){
                    $isChecked = "checked";
                }

                $switchBtn = '';
                if(auth()->user()->can('user.change.status')) {
                    $switchBtn = '<label class="switch switch-success">
                        <input type="checkbox" class="switch-input" '.$isChecked.' onclick="changeStatus(`'.route('user.change.status', $obj->id).'`)" />
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
                $buttons = '';

                if(auth()->user()->can('user.update')) {
                    $buttons .= '<a class="btn btn-primary btn-sm redirect-btn" href="' . route('user.detail', $obj->id) . '">Show</a>';
                }
                if(auth()->user()->can('user.detail')) {
                    $buttons .= '<a class="btn btn-primary btn-sm redirect-btn" href="' . route('user.update', $obj->id) . '">Update</a>';
                }
                if(auth()->user()->can('user.delete')) {
                    $buttons .= '<button class="btn btn-danger btn-sm redirect-btn" onclick="deleteData(`'. route('user.delete', $obj->id).'`)">Delete</button>';
                }

                return $buttons;
            })->rawColumns(['status', 'action'])->make(true);
    }

    public function changeStatus($userId){
        $msg = 'Something went wrong.';
        $code = 400;
        $user = $this->getUserById($userId);

        if (!empty($user)) {
            $user->update([
                'status' => !empty($user->status) ? 0 : 1
            ]);
            $msg = "User status successfully changed.";
            $code = 200;
        }

        return response()->json(['msg' => $msg], $code);
    }
}
