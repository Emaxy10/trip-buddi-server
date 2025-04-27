<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureValidAccessToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         /** @var \App\Models\User $user */
        $user = Auth::user();

        //check if user is authorized
        if(!$user || !$user->access_token){
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        try {
            $check = Http::withToken($user->access_token)->get('http://localhost/trip-buddy/public/api/check');
        } catch (\Exception $e) {
            return response()->json(['message' => 'Unable to verify session. Please try again.'], 503);
        }


        if ($check->status() === 401 && $user->refresh_token) {
            //Token expired, refresh it

            $refreshResponse = Http::post('http://localhost/trip-buddy/public/oauth/token',[
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $user->refresh_token,
                    'client_id' => config('services.passport.client_id'),
                    'client_secret' => config('services.passport.client_secret'),
            ]);

            if($refreshResponse->successful()){
                $newTokens = $refreshResponse->json();

                $user->update([
                    'access_token' => $newTokens['access_token'],
                    'refresh_token' => $newTokens['refresh_token'] ?? $user->refresh_token, // Sometimes no new refresh token
                ]);
            } else{
                Auth::logout();
                return response()->json(['message' => 'Session expired. Please login again.'], 401);
            }
            
        }
        return $next($request);
    }
}
