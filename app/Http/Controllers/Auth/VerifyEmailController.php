<?php

namespace App\Http\Controllers\Auth;

use App\Data\Auth\VerifyEmail\VerifyEmailRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use URL;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function code(VerifyEmailRequest $data): RedirectResponse
    {
        $user = Auth::user();

        $result = $user->consumeOneTimePassword($data->code);

        if (! $result->isOk()) {
            throw ValidationException::withMessages([
                'code' => __('auth.verification.code.failed'),
            ]);
        }

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinute(),
            ['id' => $user->id, 'hash' => Hash::make($user->email)],
        );

        return redirect($verificationUrl);
    }
}
