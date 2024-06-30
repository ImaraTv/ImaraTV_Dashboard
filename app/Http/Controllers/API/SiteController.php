<?php


namespace App\Http\Controllers\API;

use App\{
    Http\Controllers\Controller,
    Mail\ContactFormEmail
};
use Illuminate\{
    Http\Request,
    Support\Facades\Mail,
    Support\Facades\Validator,
};
use function request;
use function response;

class SiteController extends Controller
{

    public function __construct()
    {

    }


    public function contact(Request $request)
    {
        $validator = Validator::make($request->all(), [
                    'name' => ['required', 'string', 'max:255'],
                    'email_or_phone' => ['required', 'string', 'max:255'],
                    'message' => ['required', 'string', 'max:500'],
                    'url' => ['string']
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // send email
        $name = $request->input('name');
        $email_or_phone = $request->input('email_or_phone');
        $message = $request->input('message');
        $mail = new ContactFormEmail($name, $email_or_phone, $message);
        Mail::to([env('APP_CONTACT_EMAIL')])->send($mail);

        return response()->json(['message' => 'Email sent successfully'], 200);
    }

}
