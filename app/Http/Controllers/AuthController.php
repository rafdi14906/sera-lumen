<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\User;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/login",
     *     operationId="/login",
     *     tags={"login using jwt"},
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="dummy email : hendryrafdi@gmail.com",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="dummy password : hendry",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Returns some sample category things",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request. When required parameters were not supplied.",
     *     ),
     * )
     */
    /**
     *      @OA\SecurityScheme(
     *          type="http",
     *          description="Login with email and password to get the authentication token",
     *          name="Token based Based",
     *          in="header",
     *          scheme="bearer",
     *          bearerFormat="JWT",
     *          securityScheme="apiAuth",
     *      )
     */

    /**
     * @OA\Get(
     *     path="/check-login",
     *     operationId="/check-login",
     *     tags={"login using jwt"},
     *     @OA\Response(
     *         response="200",
     *         description="Returns some sample category things",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request. When required parameters were not supplied.",
     *     ),
     *      security={{ "apiAuth": {} }}
     * )
     */

     /**
     * @OA\Post(
     *     path="/logout",
     *     operationId="/logout",
     *     tags={"login using jwt"},
     *     @OA\Response(
     *         response="200",
     *         description="Returns some sample category things",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request. When required parameters were not supplied.",
     *     )
     * )
     */
    protected $apiHelper;

    public function __construct()
    {
        $this->apiHelper = new ApiHelper();
        $this->middleware('auth:api', ['except' => ['login', 'refresh', 'logout']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return Response
     */
    public function login(Request $request)
    {

        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['email', 'password']);

        if (!$token = Auth::attempt($credentials)) {
            $response = $this->apiHelper->make_response(0, 'Unauthorized');
            return response()->json($response);
        }

        $data = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => auth()->user(),
            'expires_in' => auth()->factory()->getTTL() * 60 * 24,
        ];
        $response = $this->apiHelper->make_response(1, 'Login success!', 1, $data);
        return response()->json($response);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function check_login()
    {
        $data = [
            'user' => auth()->user(),
        ];
        $response = $this->apiHelper->make_response(1, 'Retrieve data success!', 1, $data);
        return response()->json($response);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $data = [
            'access_token' => auth()->refresh(),
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60 * 24,
        ];
        $response = $this->apiHelper->make_response(1, 'Refresh success!', 1, $data);
        return response()->json($response);
    }
}
