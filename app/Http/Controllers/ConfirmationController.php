<?php

namespace App\Http\Controllers;

use App\Models\ConfirmationCode;
use App\Services\SaveService;
use App\Services\ConfirmationServiceFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ConfirmationController extends Controller
{
    protected ConfirmationServiceFactory $confirmationServiceFactory;

    public function __construct(ConfirmationServiceFactory $confirmationServiceFactory)
    {
        $this->confirmationServiceFactory = $confirmationServiceFactory;
    }

    /**
     * @OA\Post(
     *     path="/api/send",
     *     summary="Отправить код подтверждения",
     *     description="Отправка кода подтверждения пользователю",
     *     tags={"Confirmation"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="method", type="string", example="sms")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Код подтверждения отправлен",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Confirmation code sent")
     *         )
     *     )
     * )
     */
    public function send(Request $request)
    {
        $user = $request->user();
        $method = $request->input('method');

        $service = $this->confirmationServiceFactory->getService($method);
        $service->sendCode($user, $method);

        return response()->json(['message' => 'Confirmation code sent']);
    }

    /**
     * @OA\Post(
     *     path="/api/verify",
     *     summary="Проверить код подтверждения",
     *     description="Проверка кода подтверждения",
     *     tags={"Confirmation"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="code", type="string", example="12345"),
     *             @OA\Property(property="method", type="string", example="sms")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Код успешно проверен",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Code verified successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Неверный код подтверждения",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Invalid confirmation code")
     *         )
     *     )
     * )
     */
    public function verify(Request $request)
    {
        $user = $request->user();
        $code = $request->input('code');
        $method = $request->input('method');
        $confirmationService = $this->confirmationServiceFactory->getService($method);

        if ($confirmationService->verifyCode($user, $code, $method)) {
            return response()->json(['message' => 'Code verified successfully']);
        }

        return response()->json(['message' => 'Invalid confirmation code'], 400);
    }


    /**
     * @OA\Post(
     *     path="/api/save",
     *     summary="Сохранить пользователя",
     *     description="Сохранение пользователя",
     *     tags={"Confirmation"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="method", type="string", example="telegram")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Метод подтверждения сохранен"
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Нет контента"
     *     )
     * )
     */
    public function saveUser(Request $request)
    {
        $user = $request->user()->id;
        $method = $request->input('method');
        $confirmationController = App::make(SaveService::class);
        $confirmationController->save($user, $method);

        if ($confirmationController) {
            return response()->json(201);
        } else {
            return response()->noContent();
        }
    }

    public function save($code)
    {
        $existingRecord = ConfirmationCode::query()
            ->where('type', 'telegram')
            ->first();

        if ($existingRecord) {
            return $existingRecord->update(['code' => $code]);
        } else {
            return ConfirmationCode::create([
                'user_id' => auth()->id(),
                'code' => $code,
                'type' => 'telegram',
            ]);
        }
    }
}
