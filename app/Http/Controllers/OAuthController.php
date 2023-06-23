<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserDataResource;
use App\Models\User;
use App\Models\Userdata\UserProfile;
use App\OpenApi\Parameters\OAuthParameters;
use App\OpenApi\Responses\OAuthResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Vyuldashev\LaravelOpenApi\Attributes\Operation;
use Vyuldashev\LaravelOpenApi\Attributes\Parameters;
use Vyuldashev\LaravelOpenApi\Attributes\PathItem;
use Vyuldashev\LaravelOpenApi\Attributes\Response;

#[Prefix('oauth')]
#[PathItem]
class OAuthController extends Controller
{
    /**
     * Get user data from provider
     */
    #[Get('/call-back/{provider}')]
    #[Operation(tags: ['OAuth'], method: 'GET')]
    #[Parameters(factory: OAuthParameters::class)]
    #[Response(factory: OAuthResponse::class)]
    public function callBack($provider): JsonResponse
    {
        try {
            $oauthProvider = Socialite::driver($provider)->stateless()->user();

            $existUser = User::query()->firstWhere('email', $oauthProvider->getEmail());

            if ($existUser){
                $token = Auth::guard('api')->login($existUser);
                $userProfile = UserProfile::query()->firstWhere('user_id', $existUser->id);

                return $this->success(['token' => $token, 'user' => UserDataResource::make($existUser), 'user_id' => $existUser->id, 'userProfile' => $userProfile]);

            } else {
                $user = User::query()->updateOrCreate(
                    ['oauth_id' => $oauthProvider->getId()],
                    [
                        'name' => $oauthProvider->getName(),
                        'email' => $oauthProvider->getEmail() ?? str_replace(' ', '_', $oauthProvider->getName()).'@gmail.com',
                        'oauth_provider' => $provider,
                        'avatar' => $oauthProvider->avatar
                    ]
                );

                if (!$user) {
                    return $this->error([], 'Unauthorized', 200);
                }

                $token = Auth::guard('api')->login($user);
                $userProfile = UserProfile::query()->firstWhere('user_id', $user->id);

                return $this->success(['token' => $token, 'user' => UserDataResource::make($user), 'user_id' => $user->id, 'userProfile' => $userProfile]);


            }


        } catch (Exception $e) {
            return $this->error(['error' => 'Invalid credentials provided.'], 'This user is exist.', 200);
        }


    }

    /**
     * Login user by provider account
     */
    #[Get('/{provider}')]
    #[Operation(tags: ['OAuth'], method: 'GET')]
    #[Parameters(factory: OAuthParameters::class)]
    public function redirect($provider): RedirectResponse|\Illuminate\Http\RedirectResponse
    {

        return Socialite::driver($provider)->stateless()->redirect();
    }

}
