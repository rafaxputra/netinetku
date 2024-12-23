<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ForgotPasswordController extends Controller
{
    /**
     * Display the forgot password form.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle the forgot password form submission.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Send WhatsApp message here
        $email = $request->input('email');
        $message = "aku lali password lek, emailku " . $email;
        $whatsapp_number = "6285175175105"; 
        $whatsapp_url = "https://wa.me/" . $whatsapp_number . "?text=" . urlencode($message);

        return redirect($whatsapp_url);
    }
}
