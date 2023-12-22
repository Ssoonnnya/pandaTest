<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Verified;

class VerificationController extends Controller
{
    public function verify($token)
    {
        $verification = Verified::where('token', $token)->first();

        if ($verification) {

            Subscriptions::where('email', $verification->verified_email)->update(['status' => 'verified']);

            $verification->delete();

            return redirect()->route('subscription.index')->with('success', 'Email verified successfully');
        }

        return redirect()->route('subscription.index')->with('error', 'Invalid verification token');
    }
}
