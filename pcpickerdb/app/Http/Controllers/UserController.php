<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\ResponseController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\UserRegisterChecker;
use App\Http\Requests\UserLoginChecker;
use Carbon\Carbon;
use App\Http\Controllers\AlertController;

class UserController extends ResponseController {
    public function register(UserRegisterChecker $request) {

        $request->validated();
        $input = $request->all();
        $input["password"] = bcrypt($input["password"]);
        $user = User::create($input);
        $success ["name"] =$user->name;

        return $this->sendResponse($success, "Sikeres regisztráció");
    }

    public function login(UserLoginChecker $request) {
        $request->validated();
    
        if (Auth::attempt(["email" => $request->email, "password" => $request->password])) {
            $user = Auth::user();
    
            // Reset login attempts and remove ban if any
            (new BanController)->resetBannedData($user->email);
    
            // Return success response with authentication token
            $success["token"] = $user->createToken($user->name . "token")->plainTextToken;
            $success["name"] = $user->name;
            return $this->sendResponse($success, "Sikeres bejelentkezés");
        } else {
            $loginAttempts = (new BanController)->getLoginAttempts($request->email);
            $bannedTime = (new BanController)->getBannedTime($request->email);
    
            if ($loginAttempts < 3) {
                // Increment login attempts
                (new BanController)->setLoginAttempts($request->email);
                return $this->sendError("Adatbeviteli hiba", ["Hibás email vagy jelszó"], 401);
            } elseif (is_null($bannedTime) || $bannedTime < Carbon::now()->setTimezone('Europe/Budapest')) {
                // Set ban status and send email alert
                (new BanController)->setBannedTime($request->email);
                $bannedTime = (new BanController)->getBannedTime($request->email);
                (new AlertController)->sendEmail($request->email, $bannedTime);
                return $this->sendError("Sikertelen azonosítás", ["Túl sok próbálkozás"], 401);
            } else {
                // User is banned, return error response
                return $this->sendError("Felhasználó blokkolva", ["Következő bejelentkezés:", $bannedTime], 401);
            }
        }
    }    

    public function logout(Request $request) {
        if (auth("sanctum")->user()) {
            auth("sanctum")->user()->currentAccessToken()->delete();
            return $this->sendResponse([], "Sikeres kijelentkezés");
        } else {
            return $this->sendError("Nem vagy bejelentkezve", [], 401);
        }
    }
    
}