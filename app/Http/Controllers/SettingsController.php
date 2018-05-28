<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\settings as Settings;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    public function index(){
        return view('settings');
    }

    public function saveSettings(Request $request){


        $validation = Validator::make($request->all(),[
            'server_name' => 'required',
            'workflow' => 'required',
            'client_id' => 'required',
            'client_secret' => 'required',
        ], [
            'required' => 'The :attribute is required ',
        ]);

        if($validation->fails()){
            return redirect('/settings')->withErrors($validation, 'settings')->withInput();
        }else{

            $settings = new Settings;

            $settings->client_id =  $request->client_id;
            $settings->client_secret =  $request->client_secret;
            $settings->server = $request->server_name;
            $settings->workflow = $request->workflow;
            $settings->created_at = Carbon::now();
            $settings->updated_at = Carbon::now();
            $settings->save();

            return redirect('/');

        }



    }

}
