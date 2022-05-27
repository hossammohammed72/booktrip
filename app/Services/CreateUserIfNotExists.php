<?php 
namespace App\Services;

use App\Requests\UserRequest;
use App\Models\User;
class CreateUserIfNotExists{
    public static function getUserOrCreateIfNotExists(UserRequest $request): User
    {
        $user = User::where('email',$request->email)->first();
        if(is_null($user)){
            $user = new User(['name'=>$request->name,'email'=>$request->email]);
            $user->save();
            return $user;
        }
        return $user;
           
    }
}

?>