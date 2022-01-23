<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Helper\Helper;
use App\Http\Resources\UserResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Constant\Constants;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{

    /**
     * Create user
     *
     * @param
     *            [string] name
     * @param
     *            [string] email
     * @param
     *            [string] password
     * @param
     *            [string] password_confirmation
     * @param
     * 
     * @return  [string] message
     * @return  [object] User
     */

    //  User sign up only

    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
            'password_confirmation' => "required",
            "auto_login" => 'required|boolean'
        ]);
        try {
            DB::beginTransaction();

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->role_id = Constants::TYPE_USER;
            $user->state_id = Constants::STATE_ACTIVE;

            if ($user->save()) {

                if ($request->auto_login == Constants::STATE_ACTIVE) {
                    $tokenResult = $user->createToken('Personal Access Token');
                    $token = $tokenResult->token;
                    if ($request->remember_me) {
                        $token->expires_at = Carbon::now()->addWeek(1);
                    }
                    $token->save();
                    DB::commit();
                    return $this->success([
                        'access_token' => $tokenResult->accessToken,
                        'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
                        'data' => new UserResource($user),
                        'status' => true,
                        'code' => 200,
                        'token_type' => 'Bearer',
                        "message" => "Registered Successfully!",
                    ]);
                }
                DB::commit();
                return $this->success([
                    "message" => "Registered Successfully!",
                    'data' => $user
                ]);
            }
            DB::rollback();
            return $this->failed('User creation failed!');
        } catch (\Illuminate\Database\QueryException $exception) {
            DB::rollback();
            return $this->error($exception->errorInfo);
        }
    }

    /**
     * Login user and create token
     *
     * @param
     *            [string] email
     * @param
     *            [string] password
     * @param
     *            [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
                'remember_me' => 'boolean'
            ]);
            $credentials = request([
                'email',
                'password'
            ]);

            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'status' => false,
                    'code' => 401,
                    'message' => "Incorrect email or password entered."
                ], 401);
            }

            $user = Auth::user();
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            if ($request->remember_me) {
                $token->expires_at = Carbon::now()->addWeek(1);
            }
            $token->save();
            return response()->json([
                'access_token' => $tokenResult->accessToken,
                'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
                'data' => new UserResource($user),
                'status' => true,
                'code' => 200,
                'token_type' => 'Bearer'
            ], 200);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Get the authenticated User
     *
     * @return user object
     */
    public function user(Request $request)
    {
        return $this->success(['data' => $request->user()]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        try {
            $request->user()
                ->token()
                ->revoke();
            return $this->success('successfully logged out');
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }
}
