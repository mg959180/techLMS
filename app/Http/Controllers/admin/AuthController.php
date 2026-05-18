<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AdmUser;
use App\Services\EncryptionService;
use App\Services\LogService;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password as PasswordBroker;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Http\Request;
use App\Constants\MsgConstant;
use App\Constants\HttpStatusConstant;
use Throwable;

class AuthController extends Controller
{
    public function showLoginForm(EncryptionService $encryption)
    {
        return view('admin.auth.login', [
            'loginPublicKey' => $encryption->publicKey(),
        ]);
    }

    public function showRegisterForm()
    {
        return view('admin.auth.register');
    }

    public function authenticateApi(Request $request, EncryptionService $encryption, LogService $logs)
    {
        $validator = Validator::make($request->all(), [
            'payload' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            $logs->adminActivity(MsgConstant::INVALID_REQUEST, $request, [
                'payload' => $request->payload ?? null,
            ]);
            return response()->json([
                'success' => false,
                'message' => MsgConstant::INVALID_REQUEST,
                'errors' => $validator->errors(),
            ], HttpStatusConstant::UNPROCESSABLE_ENTITY);
        }

        try {
            $data = $encryption->decryptPayload($request->string('payload')->toString());
        } catch (Throwable) {
            $logs->adminActivity(MsgConstant::INVALID_REQUEST, $request, [
                'payload' => $request->payload ?? null,
            ]);
            return response()->json([
                'success' => false,
                'message' => MsgConstant::INVALID_REQUEST,
            ], HttpStatusConstant::BAD_REQUEST);
        }

        $credentialsValidator = Validator::make($data, [
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6', 'max:10'],
            'remember' => ['sometimes', 'boolean'],
        ]);

        if ($credentialsValidator->fails()) {
            $logs->adminActivity(MsgConstant::VALIDATION_ERROR, $request, [
                'email' => $data['email'],
                'payload' => $request->payload ?? null,
            ]);
            return response()->json([
                'success' => false,
                'message' => MsgConstant::VALIDATION_ERROR,
                'errors' => $credentialsValidator->errors(),
            ], HttpStatusConstant::UNPROCESSABLE_ENTITY);
        }

        $credentials = $credentialsValidator->safe()->only(['email', 'password']);
        $adminUser = AdmUser::where('email', $credentials['email'])->exists();
        
        if (! $adminUser) {
            $logs->adminActivity('Admin login failed: user not found.', $request, [
                'email' => $credentials['email'],
                'payload' => $request->payload ?? null,
            ]);

            return response()->json([
                'success' => false,
                'message' => MsgConstant::USER_NOT_FOUND,
            ], HttpStatusConstant::NOT_FOUND);
        }

        if (! Auth::guard('admin')->attempt($credentials, (bool) ($data['remember'] ?? false))) {
            $logs->adminActivity('Admin login failed: invalid credentials.', $request, [
                'admin_id' => $adminUser->id,
                'email' => $adminUser->email,
                'payload' => $request->payload ?? null,
            ]);

            return response()->json([
                'success' => false,
                'message' => MsgConstant::INVALID_CREDENTIALS,
                'payload' => $request->payload ?? null,
            ], HttpStatusConstant::UNAUTHORIZED);
        }

        $this->storeAdminSession($request);

        $logs->adminActivity('Admin login successful.', $request, [
            'admin_id' => $adminUser->id,
            'email' => $adminUser->email,
            'payload' => $request->payload ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => MsgConstant::LOGIN_SUCCESS,
            'redirect' => route('admin.dashboard'),
        ]);
    }

    private function storeAdminSession(Request $request): void
    {
        $request->session()->regenerate();

        $user = Auth::guard('admin')->user();

        session([
            'admin_id' => $user->id,
            'admin_name' => $user->name,
            'admin_email' => $user->email,
        ]);
    }

    public function showForgetPasswordForm()
    {
        return view('admin.auth.forget-password');
    }


    public function showResetPasswordForm(Request $request, string $token)
    {
        return view('admin.auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

}
