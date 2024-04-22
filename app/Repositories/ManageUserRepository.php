<?php


namespace App\Repositories;


use App\Interfaces\ManageUserRepositoryInterface;
use App\Models\User;
use App\Notifications\UserWelcome;
use Illuminate\Support\Facades\Auth;
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
        $role = Role::where('name', $req->role)->first();

        if(empty($role)){
            return redirect()->back()->withInput()->with('error_msg', 'Role is invalid.');
        }

        $user = User::create([
            'username' => $req->username,
            'email' => $req->email,
            'password' => $req->password,
            'is_verified' => 1
        ]);

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

            $userData['username'] = $req->username;
            $userData['email'] = $req->email;
            if(!empty($req->password)){
                $userData['password'] = $req->password;
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
                        $w->orWhere('username', 'LIKE', "%$search%")
                            ->orWhere('email', 'LIKE', "%$search%");

                        if(strtolower($search) === "unverified"){
                            $w->orWhere('is_verified', 0);
                        }elseif(strtolower($search) === "verified"){
                            $w->orWhere('is_verified', 1);
                        }

                    });
                }
            })
            ->editColumn('is_verified', function ($obj){
                return !empty($obj->is_verified)?"Verified":"unverified";
            })
            ->editColumn('is_active', function ($obj) {
                $isChecked = "";
                if(!empty($obj->is_active)){
                    $isChecked = "checked";
                }

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

                return $switchBtn;
            })
            ->addColumn('action', function ($obj) {
                $buttons = '<a class="btn btn-primary redirect-btn" href="' . route('user.detail', $obj->id) . '">Show</a>
                            <a class="btn btn-primary redirect-btn" href="' . route('user.update', $obj->id) . '">Update</a>';

                return $buttons . '  <button class="btn btn-danger redirect-btn" onclick="deleteData(`'. route('user.delete', $obj->id).'`)">Delete</button>';
            })->rawColumns(['is_active', 'action'])->make(true);
    }

    public function changeStatus($userId){
        $msg = 'Something went wrong.';
        $code = 400;
        $user = $this->getUserById($userId);

        if (!empty($user)) {
            $user->update([
                'is_active' => !empty($user->is_active) ? 0 : 1
            ]);
            $msg = "User status successfully changed.";
            $code = 200;
        }

        return response()->json(['msg' => $msg], $code);
    }
}
