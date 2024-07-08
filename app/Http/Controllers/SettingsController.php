<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ConfirmationServiceInterface;

class SettingsController extends Controller
{
    protected $confirmationService;

    public function __construct(ConfirmationServiceInterface $confirmationService)
    {
        $this->confirmationService = $confirmationService;
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $method = $request->input('method');
        return $this->confirmationService->sendCode($user, $method);
    }

    public function verify(Request $request)
    {
        $user = $request->user();
        $code = $request->input('code');
        $method = $request->input('method');

        if ($this->confirmationService->verifyCode($user, $code, $method)) {
            $user->update([$request->input('setting') => $request->input('value')]);
            return response()->json(['message' => 'Setting updated successfully']);
        }
        return response()->json(['message' => 'Invalid confirmation code'], 400);
    }
}
