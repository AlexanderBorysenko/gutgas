<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function consultationMail(Request $request)
    {
        $data = request()->validate([
            'name' => 'required|string|max:255|min:3',
            // phone should be +38 (0##) ###-##-## where # is a digit
            'phone' => 'required|regex:/^\+38 \(0\d{2}\) \d{3}-\d{2}-\d{2}$/',
            'email' => 'nullable|email',
            'question' => 'nullable|string'
        ]);

        Mail::send('emails.consultation', $data, function ($message) {
            $message->from('form-manager@gutgas.eu', 'Gutgas Sale manager');
            $message->to('sale@gutgas.eu');
            $message->subject('Заявка на консультацію');
        });

        return redirect()->route('thankYou');
    }

    public function requestCallMail(Request $request)
    {
        $data = request()->validate([
            'phone' => 'required|min:9|max:9',
        ]);

        Mail::send('emails.consultation', $data, function ($message) {
            $message->from('form-manager@gutgas.eu', 'Gutgas Sale manager');
            $message->to('sale@gutgas.eu');
            $message->subject('Заявка на дзвінок');
        });

        return redirect()->route('thankYou');
    }
}
