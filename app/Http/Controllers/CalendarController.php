<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Account as Accounts;
use App\settings as Settings;


class CalendarController extends Controller
{
    public function index(){

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

            //Get Inbox

            $ch = curl_init($apiServer . "/api/1.0/".$workflow."/cases/advanced-search");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $accessToken));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $cases= json_decode(curl_exec($ch));
            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);


            // print_r($cases[0]->app_uid);

            //schedule algo

            $a = array();



            foreach($cases as $case){
                if($case->del_task_due_date != "" || $case->del_task_due_date !=null){
                    $b = array(
                        'title'=> $case->app_tas_title,
                        'start'=> str_replace(' ', 'T', $case->del_task_due_date)
                    );
                }

                array_push($a, $b);
            }


//           print_r(json_encode($a));
           $c = json_encode($a);


            $data = array(
                'title' => 'Dashboard',
                'usr_name' => $users->usr_firstname." ".$users->usr_lastname,
                'schedules' => $c
            );

            return view('calendar' , $data);

        }



    }

    public function getSchedules(){
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

            //Get Inbox

            $ch = curl_init($apiServer . "/api/1.0/".$workflow."/cases/advanced-search");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $accessToken));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $cases= json_decode(curl_exec($ch));
            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);


            // print_r($cases[0]->app_uid);

            //schedule algo

            $a = array();



            foreach($cases as $case){

                if($case->del_task_due_date != "" || $case->del_task_due_date !=null){
                    $b = array(
                        'title'=> $case->app_tas_title,
                        'start'=> str_replace(' ', 'T', $case->del_task_due_date)
                    );
                }

                array_push($a, $b);
            }


            // print_r(json_encode($a));
            $c = json_encode($a);


            return $c;

        }



    }

}
