<?php 
namespace App\Services\Firebase;

use Google\Client as GoogleClient;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

//use App\Models\Firebase;

class FirebaseService
{
    private $setting = __DIR__ . "/hexabe-89665-firebase-adminsdk-fbsvc-cb6f9e664f.json";

    function send($firebaseUser, $title, $body, $data=[], $payload=[]){
        $client = new GoogleClient();
        $client->setAuthConfig($this->setting);
        $client->addScope("https://www.googleapis.com/auth/firebase.messaging"); 
        $client->refreshTokenWithAssertion();
        $token = $client->getAccessToken();
        $access_token = $token['access_token'];
        $projectId = config('services.fcm.project_id');
        
        $headers = [
            "Authorization: Bearer $access_token",
            'Content-Type: application/json'
        ];

        $data["title"] = $title;
        $data["body"] = $body;
        $tokenUser = $firebaseUser->token;

        $dataMessage = [
            "message" => [
                "token" => $tokenUser,
                //"token" => env('MICOMPU_TOKEN_FIREBASE'),
                //"notification" => [
                //    "title" => $title,
                //    "body" => $body
                //],
                "data" => $data
            ]
        ];

        /*
        if( $firebaseUser->source == 'MOVIL'){
            $dataMessage["message"]["notification"] = [
                "title" => $title, 
                "body" => $body
            ];
            if( empty($payload) == false ){
                $payloadCast = $this->castPayloadToString($payload);
                $dataMessage["message"]["data"] = array_merge( $data,  $payloadCast);
            }
        }
        */

        $notificationPayload = json_encode($dataMessage);
        $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $notificationPayload);
        curl_setopt($ch, CURLOPT_VERBOSE, true); // Enable verbose output for debugging
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            //TODO save log error
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/firebase.log'),
            ])->warning('service.firebaseservice.send: [' . $tokenUser . '] ' . $err);
            return false;
            //var_dump($err);exit();
        } else {
            $rd = json_decode($response, true);

            if( isset($rd['error']) ){
                $this->manageError($rd['error'], $tokenUser);
                return false;
            }

            return true;
            //var_dump($rd);exit();
        }
    }

    function castPayloadToString($payload){
        $result = [];
        foreach($payload as $key => $value){
            $result[$key] = (string) $value;
        }
        return $result;
    }

    function manageError($error, $token) {
        $details = $error['details'][0];

        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/firebase.log'),
        ])->warning('service.firebaseservice.manageError: [' . $token . '] ' . json_encode($details));

        if( isset($details['errorCode']) AND $details['errorCode'] == "UNREGISTERED"){
            $tokenModel = Firebase::where('token', $token)->first();
            if( $tokenModel != null ){
                $tokenModel->delete();
            }
        }
    }
}