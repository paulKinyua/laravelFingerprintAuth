<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegisterFingerprint;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\DB;

class fingerprintLogin extends Controller
{
    //
    public function validateFingerprint(Request $request){
        
        $loginfingerprintPath=$request->fingerprint;
        
        //fetch all fingerprints stored in the database
        $fingerprints = RegisterFingerprint::select('folder', 'filename', 'user_id')->get();
        $fingerprints2 = $fingerprints->toArray();
        $paths = array();
        for($i=0; $i<sizeof($fingerprints2); $i++){
            $details=["path"=>"/storage/app/fingerprints/register/".$fingerprints2[$i]['folder']."/".$fingerprints2[$i]['filename'], "user_id"=>$fingerprints2[$i]['user_id']];
            array_push($paths, $details);
        }
        $payload = [
            "loginFingerprint"=>$loginfingerprintPath,
            "databaseFingerprints" => $paths
        ];
        
        
        

        //for testing purposes, login the first record pulled from fetched registered fingerprints
        $user = User::where('id', $fingerprints2[0]['user_id'])->first();
        if ($user) {
            Auth::login($user);

            // Regenerate the session ID
            $request->session()->regenerate();

            // Redirect to the dashboard or any other route
            return redirect('/dashboard');
        }
       
        
    }

    public function sendCurlRequest($url, $payload){
    //send curl request to python for fingerprint verification
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json')); //setting custom header

        $data_string = json_encode($payload);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

        // // Follow redirects
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

        $curl_response = curl_exec($curl);
        curl_close($curl);
        $response2 = json_decode($curl_response, true);

        return $response2;
    }
}
