<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class BanController extends Controller
{
    public function getLoginAttempts($email) {

        $user=User::where("email", $email)->first();
        $attempts = $user->login_attempt;
        return $attempts;
    }

    public function setLoginAttempts($email) {
        User::where("email", $email)->increment("login_attempt");
    }

    public function getBannedTime($email) {
        $user=User::where("email", $email)->first();
        $bannedTime=$user->banned_time;
        return $bannedTime;
    }

    public function setBannedTime($email){
        $user=User::where("email", $email)->first();
        $bannedTime = Carbon::now()->addHours()->addSeconds(60)->setTimezone('Europe/Budapest');
        $user->banned_time=$bannedTime;
        $user->save();
        
    }

    public function resetBannedData($email) {

        $user=User::where("email", $email)->first();
        $user->login_attempt = 0;
        $user->banned_time = null;

        $user->save();
    }
}