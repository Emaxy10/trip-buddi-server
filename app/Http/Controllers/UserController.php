<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function index(){
        $users = User::all();
        
        return $users;
    }
    public function register(StoreUserRequest $request){
        $user = User::create($request->all());
        return $user;
    }

    public function login(Request $request){
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string']
        ]);

        //Attemp user authentication
        if(!Auth::attempt($request->only('email','password'))){

            throw ValidationException::withMessages([
                'email'=> ['Incorrect credentials']
            ]);

        }

        // get client
        $client = DB::table('oauth_clients')->where('id',1)->firstOrFail();
        //dd($client);

        $http = new Client();

        $response = $http->post('http://localhost/trip-buddy/public/oauth/token', [

            'json' => [
                'grant_type' => 'password',
                'client_id' => $client->id,
                'client_secret' => $client->secret,
                'username' => $request->email,
                'password' => $request->password,
                'scope' => '',
            ]
        ]);  

        return json_decode((string) $response->getBody(), true);


       
        
   
    }

}
