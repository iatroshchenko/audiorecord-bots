<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmailVerificationController extends Controller
{
    public function displayNotice(Request $request)
    {
        // Ask User to Verify Email
        return Inertia::render('VerifyEmail', [
            // params
        ]);
    }

    public function verifyEmail(Request $request)
    {
        $user = User::find($request->input('id'));
        $user->update([
            'email_verified_at' => now()
        ]);
        redirect('/');
    }
}
