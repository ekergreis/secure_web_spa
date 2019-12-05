<?php
// [OAUTH] Fonction login utilisateur
namespace App\Http\Controllers\api;

use App\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use League\OAuth2\Server\Exception\OAuthServerException;
use Psr\Http\Message\ServerRequestInterface;
use Response;
use Illuminate\Support\Carbon;
use \Laravel\Passport\Http\Controllers\AccessTokenController as ATC;

// [OAUTH] Class Login héritant de AccessTokenController de Passport
class LoginController extends ATC
{
    public function issueToken(ServerRequestInterface $request)
    {
        try {
            // [OAUTH] Récupération username (par defaut: email)
            $username = $request->getParsedBody()['username'];

            // [OAUTH] A changer en username si auth suivant username
            //$user = User::where('username', '=', $username)->first();
            $user = User::where('email', '=', $username)->first();

            // [OAUTH] Génération token
            $tokenResult = parent::issueToken($request);

            // [OAUTH] Recup infos token format json
            $content = $tokenResult->getContent();
            // [OAUTH] Informations Token json en tableau
            $data = json_decode($content, true);

            if(isset($data["error"]))
                throw new OAuthServerException('Codes acces incorrects.', 6, 'invalid_credentials', 401);

            // [OAUTH] Retours infos
            $infosRet=collect();
            //$infosRet = collect($user);
            $infosRet->put('access_token', $data['access_token']);
            $infosRet->put('token_type', 'Bearer');
            $infosRet->put('expires_at', Carbon::now()->addSeconds($data['expires_in']));
            $infosRet->put('group', $user->role);

            return Response::json(array($infosRet)[0]);
        }
        catch (ModelNotFoundException $e) {
            return response(["message" => "Internal server error"], 500);
        }
        catch (OAuthServerException $e) {
            return response(["message" => "Codes acces incorrects.', 6, 'invalid_credentials"], 401);
        }
        catch (Exception $e) {
            return response(["message" => "Internal server error"], 500);
        }
    }
}
