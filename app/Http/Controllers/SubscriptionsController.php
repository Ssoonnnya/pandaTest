<?php

namespace App\Http\Controllers;

use App\Models\Subscriptions;
use Illuminate\Http\Request;
use App\Models\Verified;

class SubscriptionsController extends Controller
{
    public function index()
    {
        return view('subscription.index');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'email' => 'required|email',
        'olx_url' => 'required|url',
    ]);

    $email = $request->get('email');
    $olxUrl = $request->get('olx_url');

    $subscription = Subscriptions::create([
        'email' => $email,
        'olx_url' => $olxUrl,
        'status' => 'pending',
    ]);

    $isVerified = $this->isEmailVerified($email);

    if ($isVerified) {

        $subscription->update(['status' => 'verified']);
    } else {

        $this->sendVerificationToUser($email);
    }
}



    private function isEmailVerified($email)
    {
        return Verified::where('verified_email', $email)->exists();
    }

    protected function sendVerificationToUser($recipient)
    {
        $verificationToken = str_random(32);

        Verified::create([
            'verified_email' => $recipient,
            'token' => $verificationToken,
        ]);

        $verificationLink = route('email.verify', ['token' => $verificationToken]);

        $mailgun = Mailgun::create(config('services.mailgun.secret'));

        $mailgun->messages()->send(config('services.mailgun.domain'), [
            'from' => config('mail.from.address'),
            'to' => $recipient,
            'subject' => 'Підтвердження електронної адреси.',
            'html' => view('email.verification', compact('verificationLink'))->render(),
        ]);

        echo "Verification email sent to $recipient";
    }


}
