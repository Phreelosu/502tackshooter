<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\AlertMail;
use Illuminate\Support\Facades\Mail;

class AlertController extends Controller {
    
    public function sendEmail($user, $time) {

        $content =[
            "title"=>"Felhasználó blokkolva",
            "user"=>$user,
            "time"=>$time

        ];
        //xotob99236@ricorit.com
        Mail::to("ratkaydaniel@ktch.hu")->send(new AlertMail($content));
    }
}