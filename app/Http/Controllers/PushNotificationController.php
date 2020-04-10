<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PushNotificationController extends Controller
{
    public $server_key  = "AAAAjwklA8o:APA91bEVMVvfd6nQRZHqyL65IkNwiIr2dVJgyI7DZbwNYgn8NSU-lawq1S44Y3xZ1sntAj0MeytcYBY_OHEW1iBdGFWJKnDEIOgjqCOZAiMcWCBVrp37FfgEKMSs3lp43kqaJt_yJ8uo";
    
    function send($device_token , $data) {
        
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array (
                'to' => "dMr8zvebdjVtUIaBi1MpW9:APA91bEOtmrpgGC5SyddxTihfPglTYFy9-UCw4nJ_CQ82pGPeju43prfMQQkzt0Lm5t-jhodlUbjfBil_V1nYnvTVMTHV6394rCIA43X0cHTVK28MV43JwwQ8MYE4vGYMfBkiY2kK2Uy",
                'notification' => $data
        );
        $fields = json_encode ( $fields );
        $headers = array (
                'Authorization: key=' . $this->server_key,
                'Content-Type: application/json'
        );
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

        $result = curl_exec ( $ch );
        curl_close ( $ch );
        return $result;

    }
    public function  sendNotify(Request $request)
    {
        $data = [
            'title' => "TEST NOTIFICATION ISM DEVME",
            'message' => "DEVME MESSAGE",
            'link' => "github.com/madi-madi",
            'code' => "CDFF2010"
        ];
        
       $s =  $this->send('oh876754323231@#$', $data);
        return  $s;

    }
}
