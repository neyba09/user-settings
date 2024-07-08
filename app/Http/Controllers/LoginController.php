<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateLoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     *
     * @OA\Post(
     *     path="/api/login",
     *     tags={"Авторизация, заполнение формы"},
     *     summary="Авторизация пользователя",
     *     operationId="authUser",
     *    @OA\Parameter(
     *             name="email",
     *             in="query",
     *             required=true,
     *             @OA\Schema(type="string"),
     *             description="Email пользователя"
     *         ),

     *     @OA\Parameter(
     *             name="password",
     *             in="query",
     *             required=true,
     *             @OA\Schema(type="string"),
     *             description="Пароль пользователя"
     *         ),
     *     @OA\Response(
     *         response="200",
     *         description="Ok",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Success"),
     *             @OA\Property(property="status", type="boolean", example=true)
     *         ),
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ValidateLoginRequest")
     *     )
     * )
     **/

    public function login(ValidateLoginRequest $request)
    {
        $credentials = [
            'email' => $request['email'],
            'password' => $request['password'],
        ];

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'status' => false,
                'message' => "Неверный логин или пароль"
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => "Success",
            'token' => $request->user()->createToken('sa_token')->plainTextToken
        ]);

    }
}
