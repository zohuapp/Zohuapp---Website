<?php

/**

 * File name: AjaxController.php

 * Last modified: 2025.04.01

 * AjaxController

 * Copyright (c) 2025

 */

namespace App\Http\Controllers\Auth;

use App\Models\VendorUsers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\NewUserSignUp;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

class AjaxController extends Controller
{

    /**
     * Summary of checkEmail
     * @param string $email
     * @param mixed $name
     * @param mixed $uuid
     * @return void
     */
    protected function checkEmail(string $email, string $name, string $uuid): void
    {
        $route = route('proceed-to-signup', $uuid);
        Mail::to($email)->queue(new NewUserSignUp($route, $name));
    }

    /**
     * Check if user exist or not, and send an email verification to the new user.
     * @return mixed
     */
    protected function setToken(Request $request)
    {
        // Validate the request data
        $uuid = $request->firebase_uuid;
        $email = $request->email;
        $password = $request->password;
        $name = $request->name;

        $exist = VendorUsers::where('email', $email)->exists();

        // Check if the user already exists in the vendor_users table
        try {
            if (!$exist) {
                // Create new user and add to vendor_users table
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make($password),
                ]);

                VendorUsers::create([
                    'user_id' => $user->id,
                    'uuid' => $uuid,
                    'email' => $email,
                ]);

                // Send email verification
                $this->checkEmail($user->email, $user->name, $uuid);

                // proceed to the verify page
                return view('auth.verify');
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

            return to_route('home');

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Create a new user after verifying user's email address.
     * @return mixed
     */
    protected function proceedToSignupView($uuid)
    {
        return view('auth.proceed-to-signup', compact('uuid'));
    }

    /**
     * Create a new user after verifying user's email address.
     * @return mixed
     */
    protected function proceedToVerifyEmail(VendorUsers $vendor_users, Request $request)
    {
        $vendor_user = $vendor_users->where('uuid', $request->uuid)->first();

        try {
            // Verify the email and update the email_verified_at field in the users table
            $vendor_user->user->email_verified_at = now();
            $vendor_user->user->save();

            Auth::login($vendor_user->user, true);
            // send a successful response
            // return true;
            // return to_route('home');
            return response()->json(
                ['message' => 'Email verified successfully.', 'status' => 200],
            );
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()])->statusCode(500);
            // return $e->getMessage();
        }
        // return view('auth.proceed-to-signup');
    }

    protected function setTokenOLD(Request $request)
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

    protected function logoutOLD(Request $request)
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

    protected function logout(Request $request)
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

    protected function newRegister(Request $request)
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
