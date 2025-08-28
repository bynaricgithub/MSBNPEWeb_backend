<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\Authentication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Authentication $au)
    {

        // return $au->adminLogin($email, $password, $request);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, Authentication $au)
    {

        $email = de($request->email);
        $password = de($request->password);

        $validator = Validator::make(['email' => $email, 'password' => $password], [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => stringifyValidationArray($validator->errors()->getMessages()),
            ], 400);
        }

        return $au->adminLogin($email, $password, $request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        echo 'dddd';
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function registration(Request $request, Authentication $au)
    {
        $name = de($request->name);
        $email = de($request->email);
        $password = de($request->password);
        $role = de($request->role);

        $validator = Validator::make(['email' => $email, 'password' => $password, 'role' => $role], [
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => stringifyValidationArray($validator->errors()->getMessages()),
            ], 400);
        }

        return $au->adminRegistration($name, $email, $password, $role, $request);
    }

    public function logout(Request $request, Authentication $au)
    {
        return $au->logout($request);
    }

    public function whoAmI(Authentication $au)
    {
        return $au->whoAmI();
    }
}
