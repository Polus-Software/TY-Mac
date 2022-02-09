<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Support\Facades\Auth;

class UserService {
    /**
     * Get user fullname by user id
     * @param - userId
     * @output - fullname
     */
    public static function getUserFullName($userId) {
        return User::find($userId)->firstname.' '.User::find($userId)->lastname;
    }

    /**
     * Get user email id by user id
     * @param - userId
     * @output - email id
     */
    public static function getUserEmail($userId) {
        return User::find($userId)->email;
    }

    /**
     * Get user email id by user id
     * @param - userId
     * @output - email id
     */
    public static function getUserInfo($userId) {
        return DB::table('users')->where('id', $userId)->first();
    }

    /**
     * Get user role by role id
     * @param - roleId
     * @output - role name
     */
    public static function getRoleName($roleId) {
        return UserType::find($roleId)->user_role;
    }

    /**
     * Get logged in user info
     * @param - 
     * @output - user info
     */
    public static function getCurrentUserInfo() {
        return Auth::user();
    }

    /**
     * Get user email id by user id
     * @param - userId
     * @output - email id
     */
    public static function getUserProfilePhoto($userId) {
        return User::where('id', $userId)->value('image');
    }

}