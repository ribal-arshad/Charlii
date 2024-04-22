<?php


namespace App\Http\Controllers;


use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Interfaces\ManageUserRepositoryInterface;

class ManageUserController extends Controller
{
    private ManageUserRepositoryInterface $manageUserRepository;

    public function __construct(ManageUserRepositoryInterface $manageUserRepository)
    {
        $this->manageUserRepository = $manageUserRepository;
    }

    public function manageUser(){
        if (request()->ajax()) {
            return $this->manageUserRepository->getDataTable();
        }

        return view('manage-user.index');
    }

    public function addUser(){

        return view('manage-user.add');
    }

    public function addUserData(UserStoreRequest $request){
        return $this->manageUserRepository->createUser($request);
    }

    public function updateUser($userId){

        $user = $this->manageUserRepository->getUserById($userId);

        if (!empty($user)){
            return view('manage-user.update', compact('user'));
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
}
