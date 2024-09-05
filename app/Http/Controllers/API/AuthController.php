<?php

namespace App\Http\Controllers\API;
use App\Helper\APIResponseHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Laravel\Passport\Token;

class AuthController extends Controller
{
    /**
     * Handle login request and generate access token.
     */
    public function login(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return APIResponseHelper::sendError($message = "Validation failed.",$status = 422, $errors = $validator->errors());
        }
        
        // Attempt to authenticate the user
        if (!Auth::attempt($request->only('email', 'password'))) {
            return APIResponseHelper::sendError($message = "Unauthorized.",$status = 401);
        }

        // Retrieve authenticated user
        $user = Auth::user();

        // Create a token for the user
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->accessToken;

        return APIResponseHelper::sendResponse($data = [
            'access_token' => $token,
            'token_type' => 'Bearer',
            // 'expires_at' => $tokenResult->token->expires_at
        ], $message="Login successful.");
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        $user->tokens->each(function (Token $token) {
            $token->delete();
        });

        return APIResponseHelper::sendResponse($message="Logout successful.");
    }
}
