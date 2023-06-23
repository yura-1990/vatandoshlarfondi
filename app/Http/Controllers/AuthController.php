<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Http\Resources\UserDataResource;
use App\Mail\SendMailResetPassword;
use App\Mail\SentLinkToEmail;
use App\Models\User;
use App\Models\Userdata\UserProfile;
use App\OpenApi\Parameters\ValidateTokenParameters;
use App\OpenApi\RequestBodies\LoginRequestBody;
use App\OpenApi\RequestBodies\ResetPasswordRequestBody;
use App\OpenApi\RequestBodies\SendMailRequestBody;
use App\OpenApi\RequestBodies\SetPasswordRequestBody;
use App\OpenApi\Responses\SendEmailResetPasswordResponse;
use App\OpenApi\Responses\SendMailResponse;
use App\OpenApi\Responses\SuccessAuthResponse;
use App\OpenApi\Responses\ValidateTokenResponse;
use GuzzleHttp\Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;
use Vyuldashev\LaravelOpenApi\Attributes\Operation;
use Vyuldashev\LaravelOpenApi\Attributes\Parameters;
use Vyuldashev\LaravelOpenApi\Attributes\PathItem;
use Vyuldashev\LaravelOpenApi\Attributes\RequestBody;
use Vyuldashev\LaravelOpenApi\Attributes\Response;

#[Prefix('auth')]
#[PathItem]
class AuthController extends Controller
{
    /**
     * Send confirmation token to email
     */
    #[Post('send-mail')]
    #[Operation(tags: ['Auth'], method: 'POST')]
    #[RequestBody(factory: SendMailRequestBody::class)]
    #[Response(factory: SendMailResponse::class)]
    public function sendMail(Request $request): JsonResponse
    {
        $language = $request->header('language', 'uz');

        App::setLocale($language);

        $data = $request->validate([
            'email' => 'required|email|unique:pgsql.users,email'
        ],[
            'email' => Lang::get('validation.email')
        ]);

        $data = ['token' => Str::random(60), 'email' => $data['email']];
        Cache::put($data['token'], $data, 600);

        Mail::to($data['email'])->send(new SentLinkToEmail($data));

        $message = Lang::get('messages.A confirmation link has been sent to your email address.');

        return $this->success(['message' => $message]);
    }

    /**
     * validate token
     */

    #[Post('validate-token')]
    #[Operation(tags: ['Auth'], method: 'Post')]
    #[Parameters(factory: ValidateTokenParameters::class)]
    #[Response(factory: ValidateTokenResponse::class)]
    public function validateToken($token = null): JsonResponse
    {
        if (Cache::get($token) === $token) {
            return $this->success(['message' => true]);
        }
        return $this->error([], 'Unauthorized', 401);
    }

    /**
     * Set user password
     */
    #[Post('set-password')]
    #[Operation(tags: ['Auth'], method: 'POST')]
    #[RequestBody(factory: SetPasswordRequestBody::class)]
    #[Response(factory: SuccessAuthResponse::class)]
    public function setPassword(Request $request): JsonResponse
    {
        $data = $request->validate([
            'token' => 'required|size:60',
            'password' => 'required|min:6|confirmed',
        ]);

        if (Cache::has($data['token'])) {

            $cachedData = Cache::get($data['token']);
            $email = $cachedData['email'];
            $user = User::query()->firstWhere('email', $email);
            if ($user) {
                if ($user->status === StatusEnum::ACTIVE->value) {
                    $user->update([
                        'password' => Hash::make($data['password'])
                    ]);
                    return $this->success(['message' => 'successfully operation']);
                }
                return $this->error([], 'This user has been blocked!');
            }
            $user = User::query()->create([
                'email' => $email,
                'password' => Hash::make($data['password'])
            ]);

            $token = Auth::guard('api')->login($user);

            return $this->success([
                'user' => $user,
                'token' => $token
            ]);
        }

        return $this->error([], __('The token has expired or not found'), 401);
    }

    /**
     * Login user by email and password
     */
    #[Post('login')]
    #[Operation(tags: ['Auth'], method: 'POST')]
    #[RequestBody(factory: LoginRequestBody::class)]
    #[Response(factory: SuccessAuthResponse::class)]
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $credentials = $request->only('email', 'password');

        if (!$token = auth()->guard('api')->attempt($credentials)) {
            return $this->error([], 'Unauthorized', 401);
        }
//        dd($credentials);
        $user = new UserDataResource(User::query()->where('email', $request->email)->first());
        $userProfile = UserProfile::where('user_id', auth()->guard('api')->id())->first();
        return $this->success(['token' => $token, 'user' => auth()->guard('api')->user(), 'profile' =>$userProfile ]);

    }

    /**
     * reset password
     */
    #[Post('reset-password')]
    #[Operation(tags: ['Auth'], method: 'POST')]
    #[RequestBody(factory: ResetPasswordRequestBody::class)]
    #[Response(factory: SendEmailResetPasswordResponse::class)]
    public function resetPassword(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::query()->firstWhere('email', $data['email']);

        if ($user) {
            $data = ['token' => Str::random(60), 'email' => $data['email']];

            Cache::put($data['token'], $data, 600);

            Mail::to($user->email)->send(new SendMailResetPassword($data));

            return $this->success(['message' => __('Sent reset password link to the email')]);
        }

        return $this->error(['email' => [__('User is not found')]]);
    }
}
