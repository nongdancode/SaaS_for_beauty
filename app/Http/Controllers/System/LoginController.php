<?php
/**
 * Created by IntelliJ IDEA.
 * User: letua
 * Date: 2/24/2020
 * Time: 1:54 PM
 */

namespace App\Http\Controllers\System;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Model\UserAdmin;
use App\Http\Controllers\Controller;
use App\Lib\MyUtils;

use Illuminate\Http\Request;
class LoginController extends Controller
{
    public $loginAfterSignUp = true;

    function __construct(Request $request)
    {

        $this->util = new MyUtils();
        $this->Staff = new UserAdmin();



    }



    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $input = $request->only('email', 'password');
        $token = null;

        if (!$token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'token' => $token,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function logout(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        try {
            JWTAuth::invalidate($request->token);

            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out'
            ], 500);
        }
    }


}
