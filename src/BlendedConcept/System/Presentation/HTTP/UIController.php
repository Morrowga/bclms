<?php

namespace Src\BlendedConcept\System\Presentation\HTTP;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;
use Src\Common\Infrastructure\Laravel\Controller;
use Src\BlendedConcept\System\Domain\Mail\ContactMail;

class UIController extends Controller
{
    /**
     * Display the file manager view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function sendMail(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // Send the email
        $name = $request->input('first_name') . ' ' . $request->input('last_name');
        $email = $request->input('email');
        $message = $request->input('message');

        Mail::to('mr.alvin199818@gmail.com')->send(new ContactMail($name, $email, $message));

        return response()->json(['success' => 'Email sent successfully']);
    }
}
