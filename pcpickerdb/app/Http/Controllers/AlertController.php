<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\AlertMail;
use Illuminate\Support\Facades\Mail;

class AlertController extends Controller {
    
    public function sendEmail($user, $time) {
        error_log("Sending email to: " . $user); // Debug statement

        $content =[
            "title"=>"Felhasználó blokkolva",
            "user"=>$user,
            "time"=>$time

        ];
        Mail::to("ratkaydaniel@ktch.hu")->send(new AlertMail($content));
    }
}