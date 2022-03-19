<?php

namespace App\Http\Controllers;

class IntegrasiAPIController extends Controller
{
    public function index()
    {
        // $data = [
        //     "email" => "eve.holt@reqres.in",
        //     "password" => "pistol"
        // ];
        $data = '{"email":"eve.holt@reqres.in","password":"pistol"}';

        $response = $this->apiHelper->hit("https://reqres.in/api/login", "post", [], $data);

        return response()->json($response);
    }
}
