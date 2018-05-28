<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Account as Accounts;
use App\settings as Settings;

class ProjectsController extends Controller
{
    public function index(){

        //Query First if setting has been setup

        $settings= Settings::all()->first();

        if(!$settings){
            return redirect('/')->withErrors(['login' => 'settings has not been setup']);
        }else{

            if($settings->access_token == NULL){
                return redirect('/')->withErrors(['login' => 'You must login first']);
            }

            $accessToken = $settings->access_token;
            $apiServer = $settings->server;
            $workflow = $settings->workflow;
            $username = $settings->username;

            $ch = curl_init($apiServer . "/api/1.0/".$workflow."/users?filter=".$username);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $accessToken));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $aUsers = json_decode(curl_exec($ch));
            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            //save ito account table


            if($users = Accounts::all()->first()){ //check first if there is an existing record

                $users->usr_uid = $aUsers[0]->usr_uid;
                $users->usr_username = $aUsers[0]->usr_username;
                $users->usr_firstname = $aUsers[0]->usr_firstname;
                $users->usr_lastname = $aUsers[0]->usr_lastname;
                $users->usr_email =$aUsers[0]->usr_email;
                $users->usr_address = $aUsers[0]->usr_address;
                $users->created_at = Carbon::now();
                $users->updated_at = Carbon::now();
                $users->save();

            }else{
                $accounts = new Accounts;

                $accounts->usr_uid = $aUsers[0]->usr_uid;
                $accounts->usr_username = $aUsers[0]->usr_username;
                $accounts->usr_firstname = $aUsers[0]->usr_firstname;
                $accounts->usr_lastname = $aUsers[0]->usr_lastname;
                $accounts->usr_email =$aUsers[0]->usr_email;
                $accounts->usr_address = $aUsers[0]->usr_address;
                $accounts->created_at = Carbon::now();
                $accounts->updated_at = Carbon::now();
                $accounts->save();

            }


            $users = Accounts::all()->first();

            //Get Projects

            $ch = curl_init($apiServer . "/api/1.0/".$workflow."/project");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $accessToken));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $projects= json_decode(curl_exec($ch));
            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);


            // print_r($cases[0]->app_uid);


            $data = array(
                'title' => 'Dashboard',
                'usr_name' => $users->usr_firstname." ".$users->usr_lastname,
                'projects' =>$projects
            );

            return view('projects' , $data);

        }

        function pmRestRequest($method, $endpoint, $aVars = null, $accessToken = null) {
            global $pmServer;


            $ch = curl_init($pmServer . $endpoint);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $accessToken));
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $method = strtoupper($method);

            switch ($method) {
                case "GET":
                    break;
                case "DELETE":
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                    break;
                case "PUT":
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                case "POST":
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($aVars));
                    break;
                default:
                    throw new Exception("Error: Invalid HTTP method '$method' $endpoint");
                    return null;
            }

            $oRet = new StdClass;
            $oRet->response = json_decode(curl_exec($ch));
            $oRet->status   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($oRet->status == 401) { //if session has expired or bad login:
                header("Location: loginForm.php"); //change to match your login method
                die();
            }
            elseif ($oRet->status != 200 and $oRet->status != 201) { //if error
                if ($oRet->response and isset($oRet->response->error)) {
                    print "Error in $pmServer:\nCode: {$oRet->response->error->code}\n" .
                        "Message: {$oRet->response->error->message}\n";
                }
                else {
                    print "Error: HTTP status code: $oRet->status\n";
                }
            }

            return $oRet;
        }




    }
}
