<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\settings as Settings;
use App\Account as Accounts;


class LoginController extends Controller
{
    public function index(){

    }

    public function login(Request $request){


        $settings= Settings::all()->first();

        if(!$settings){
            return redirect('/')->withErrors(['login' => 'settings has not been setup']);
        }

        $pmServer    = $settings->server;
        $pmWorkspace = $settings->workflow;
        $clientId = $settings->client_id;
        $clientSecret = $settings->client_secret;

        $postParams = array(
            'grant_type'    => 'password',
            'scope'         => '*',       //set to 'view_process' if not changing the process
            'client_id'     => $clientId,
            'client_secret' => $clientSecret,
            'username'      => $request->username,
            'password'      => $request->password
        );

        $ch = curl_init("$pmServer/$pmWorkspace/oauth2/token");
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postParams);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $oToken = json_decode(curl_exec($ch));
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);



        if ($httpStatus != 200) {
            echo $oToken->error_description;

            return redirect()->back()->withInput()->withErrors(['login' => $oToken->error_description]);
        }
        elseif (isset($oToken->error)) {
            echo "Error logging into $pmServer:\n" .
                "Error:       {$oToken->error}\n" .
                "Description: {$oToken->error_description}\n";

        }
        else {

            //If saving them as cookies:
            setcookie("access_token",  $oToken->access_token,  time() + 86400);
            setcookie("refresh_token", $oToken->refresh_token); //refresh token doesn't expire
            setcookie("client_id",     $clientId);
            setcookie("client_secret", $clientSecret);

            //SAVE ACCESS token

            $settings= Settings::all()->first();

            $settings->access_token = $oToken->access_token;
            $settings->refresh_token = $oToken->refresh_token;
            $settings->username = $request->username;
            $settings->created_at = Carbon::now();
            $settings->updated_at = Carbon::now();
            $settings->save();

            return redirect('home');
        }




    }

    public function logout(){

        Accounts::truncate();


        $settings= Settings::all()->first();

        $settings->access_token = null;
        $settings->refresh_token = null;
        $settings->username = null;
        $settings->created_at = Carbon::now();
        $settings->updated_at = Carbon::now();
        $settings->save();

        return redirect('/');

    }
}
