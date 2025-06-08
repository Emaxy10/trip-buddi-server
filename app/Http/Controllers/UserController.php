<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Models\Role;
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
        $users = User::with('roles')->get();

          // Transform the collection
    $mappedUsers = $users->map(function($user) {
        return [
            "id" => $user->id,
            "name" => $user->name,
            "email"=>$user->email,
            // "roles" => $user->roles->pluck('name') // Assuming each role has a 'name' field
            "roles" => $user->roles->map(function($role){
                return [
                    "id" => $role->id,
                    "name" => $role->name
                ];
            })
        ];
    });
        
        return response()->json($mappedUsers);
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

        // Get the authenticated user
    /** @var \App\Models\User $user */
        $user = Auth::user();

        // get client
        $client = DB::table('oauth_clients')->where('id','9e9a3f5c-7b36-4aa3-bb89-4fa2f43d4c0d')->firstOrFail();
        // dd($client);

        $http = new Client();
    try{
        $response = $http->post('http://localhost/trip-buddy/public/oauth/token', [

            'form_params' => [
                'grant_type' => 'password',
                'client_id' => $client->id,
                'client_secret' => $client->secret,
                'username' => $request->email,
                'password' => $request->password,
                'scope' => '',
            ]
        ]);  

     $tokenData = json_decode((string) $response->getBody(), true);


    // (Optional) update tokens in the user table
    $user->update([
        'access_token' => $tokenData['access_token'],
        'refresh_token' => $tokenData['refresh_token'],
    ]);

     $user_roles = $user->roles;

    return response()->json([
        'user' => $user,
        
        'access_token' => $tokenData['access_token'],
        'refresh_token' => $tokenData['refresh_token'],
        'token_type' => $tokenData['token_type'],
        'expires_in' => $tokenData['expires_in'],
    ]);
     
   
    }catch (\Exception $e) {
        // Log the error or return the error response.
        dd($e->getMessage());
    }
}

public function remove(User $user){
    return $user->delete();
}

public function assign_role(User $user, Request $request){
    $validated = $request->validate([
        'role' => 'required|exists:roles,id'
    ]);

    
    return $user->assignRole($validated['role']);

    // $roleId = $request->input('role');
    // $role = Role::findOrFail($roleId); // Throws 404 if not found
    // return $user->assignRole($role);

}

public function remove_role(User $user, Request $request){
   
    $validated = $request->validate([
        'role' => 'required'
    ]);

    return $user->removeRole($validated['role']);
}
public function search($search){

    $users = User::where('name', 'like', "%{$search}%")
    ->orWhere('email', 'like', "%{$search}%")
    ->orWhereHas('roles', function($queri) use($search){
        $queri->where('name', 'like', "%{$search}%");
    })
    ->with('roles')
    ->get()
    ->map(function($user){
        return [
            "id" => $user->id,
            "name" => $user->name,
            "email" => $user->email,
            "roles" =>  $user->roles->map(function($role){
                return [
                    "id" => $role->id,
                    "name" => $role->name
                ];
            })
        ];
    });

    // map() function is used to transform each item in a collection. 
    // In his case, it's being used to iterate through each $place object, 
    // extract specific properties, and apply transformations (such as adding the asset URL for the image).

    return response()->json($users);
}

}
