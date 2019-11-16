<?php
// [OAUTH] Fonctions de base gestion accès utilisateur

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
     /**
     * Création user (admin)
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
            ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $user->save();

        return response()->json(['message' => 'Utilisateur créé !!!'], 201);
    }

    /**
     * Authentification user
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials))
            return response()->json(['message' => 'Accès refusé'], 401);

        $user = $request->user();

        $tokenResult = $user->createToken('Access Token '.$user->email);
        $token = $tokenResult->token;

        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);

        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
            'group' => $user->role
            ]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Déconnexion OK']);
    }

    /**
     * Retourne les infos utilisateurs (admin)
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * [ROLE] Retourne le menu adapté à l'utilisateur suivant son role
     *
     * @return [json] user object
     */
    public function menu(Request $request)
    {
        $tabMenu['user']=$request->user()->name;

        if($request->user()->role()) {
            $tabMenu['menu'][]=['label'=>'Page 2',
                            'icon'=>'lock_open',
                            'souslabel'=>'pour tous',
                            'to'=>'/page2'];
        }

        if($request->user()->role('standard')) {
            $tabMenu['menu'][]=['label'=>'Page 1',
                            'icon'=>'lock_open',
                            'souslabel'=>'standard',
                            'to'=>'/page1'];
        }

        if($request->user()->role(['admin'])) {
            $tabMenu['menu'][]=['label'=>'Info User',
                            'icon'=>'verified_user',
                            'souslabel'=>'admin',
                            'to'=>'/user'];
        }

        return response()->json($tabMenu);
    }
}
