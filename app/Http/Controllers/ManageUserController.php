<?php


namespace App\Http\Controllers;


use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Interfaces\ManageRoleRepositoryInterface;
use App\Interfaces\ManageUserRepositoryInterface;
use App\Models\User;

class ManageUserController extends Controller
{
    private ManageUserRepositoryInterface $manageUserRepository;
    private ManageRoleRepositoryInterface $manageRoleRepository;

    public function __construct(ManageUserRepositoryInterface $manageUserRepository, ManageRoleRepositoryInterface $manageRoleRepository)
    {
        $this->manageUserRepository = $manageUserRepository;
        $this->manageRoleRepository = $manageRoleRepository;
    }

    public function manageUser(){
        if (request()->ajax()) {
            return $this->manageUserRepository->getDataTable();
        }

        return view('manage-user.index');
    }

    public function addUser()
    {
        $roles = $this->manageRoleRepository->getActiveRolesToCreateUser();

        return view('manage-user.add', compact('roles'));
    }

    public function addUserData(UserStoreRequest $request){
        return $this->manageUserRepository->createUser($request);
    }

    public function updateUser($userId){

        $user = $this->manageUserRepository->getUserById($userId);
        $roles = $this->manageRoleRepository->getActiveRolesToCreateUser();


        if (!empty($user)){
            return view('manage-user.update', compact('user', 'roles'));
        }

        abort(404);
    }

    public function updateUserData($userId, UserUpdateRequest $request){
        return $this->manageUserRepository->updateUser($userId, $request);
    }

    public function getUserDetail($userId){
        $user = $this->manageUserRepository->getUserById($userId);
        return view('manage-user.detail', compact('user'));
    }

    public function changeUserStatus($userId){
        return $this->manageUserRepository->changeStatus($userId);
    }

    public function deleteUser($userId){
        return $this->manageUserRepository->deleteUser($userId);
    }

    public function getActiveUsers()
    {
        $users = User::where('status', 1)->get();

        return response()->json(['options' => $users]);
    }
}
