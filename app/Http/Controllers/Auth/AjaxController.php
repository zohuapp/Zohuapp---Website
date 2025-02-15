<?php

/**

 * File name: AjaxController.php

 * Last modified: 2020.06.11 at 16:10:52

 * AjaxController

 * Copyright (c) 2020

 */

namespace App\Http\Controllers\Auth;



use App\Models\VendorUsers;

use App\Models\User;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Exception;

class AjaxController extends Controller

{

    public function checkEmail(Request $request)
    {
        $response = array();

        if (User::where('email', $request->email)->exists()) {
            $response['exist'] = 'yes';
        } else {
            $response['exist'] = 'no';
        }

        return response()->json($response);
    }


    public function setToken(Request $request)
    {

        // $userId = $request->userId;
        $uuid = $request->id;
        $password = $request->password;
        $email = $request->email;
        $exist = VendorUsers::where('email', $email)->exists();
        // $data = $exist->isEmpty();

        try {
            //code...
            if (!$exist) {
                // Create new user and add to vendor_users table
                $user = User::create([
                    'name' => $request->email,
                    'email' => $request->email,
                    'password' => Hash::make($password),
                ]);

                VendorUsers::create([
                    'user_id' => $user->id,
                    'uuid' => $uuid,
                    'email' => $request->email,
                ]);
            } elseif ($exist) {
                // Update existing user and add to vendor_users table
                $user = VendorUsers::select('id')->where('email', $email)->first();

                $user = VendorUsers::find($user->id);

                $user->uuid = $uuid;
                $user->email = $request->email;

                $user->save();
            }

            $user = User::where('email', $request->email)->first();

            Auth::login($user, true);

            $data = array();

            if (Auth::check()) {
                $data['access'] = true;
            }

            return $data;
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function setTokenOLD(Request $request)
    {
        $userId = $request->userId;

        $uuid = $request->id;

        $password = $request->password;

        $exist = VendorUsers::where('user_id', $userId)->get();

        $data = $exist->isEmpty();

        if ($exist->isEmpty()) {

            DB::table('vendor_users')->insert([

                'user_id' => $userId,

                'uuid' => $uuid,

                'email' => $request->email,



            ]);



            User::create([

                'name' => $request->email,

                'email' => $request->email,

                'password' => Hash::make($password),

            ]);
        } else {
        }







        $user = User::where('email', $request->email)->first();







        Auth::login($user, true);

        $data = array();

        if (Auth::check()) {



            $data['access'] = true;
        }





        return $data;
    }



    public function logoutOLD(Request $request)
    {



        $user_id = Auth::user()->user_id;

        $user = VendorUsers::where('user_id', $user_id)->first();



        try {

            Auth::logout();
            return redirect('/login');
        } catch (\Exception $e) {

            $this->sendError($e->getMessage(), 401);
        }



        $data1 = array();

        if (!Auth::check()) {

            $data1['logoutuser'] = true;
        }

        return $data1;
    }

    public function logout(Request $request)
    {

        $user_id = Auth::user()->user_id;
        $user = VendorUsers::where('user_id', $user_id)->first();

        try {
            Auth::logout();
            return redirect('/login');
        } catch (\Exception $e) {
            $this->sendError($e->getMessage(), 401);
        }

        $data1 = array();
        if (!Auth::check()) {
            $data1['logoutuser'] = true;
        }
        return $data1;
    }

    public function newRegister(Request $request)
    {

        $userId = $request->userId;

        $password = $request->password;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
        ]);

        DB::table('vendor_users')->insert([
            'user_id' => $user->id,
            'uuid' => $userId,
            'email' => $request->email,
        ]);


        $user = User::where('email', $request->email)->first();

        Auth::login($user, true);

        $signUpData = array();

        if (Auth::check()) {
            $signUpData['access'] = true;
        }
        return $signUpData;
    }
}
