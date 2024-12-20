<?php


namespace App\Http\Controllers\API;

use App\{Http\Controllers\Controller,
    Mail\ContactFormEmail,
    Mail\NewsletterRegistrationEmail,
    Services\NewsletterService};
use Illuminate\{
    Http\Request,
    Support\Facades\Mail,
    Support\Facades\Validator,
};
use MailchimpMarketing\ApiClient;
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

    public function newsletterSubscribe(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'email', 'max:255']
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }
            $email = $request->input('email');

            $response = NewsletterService::subscribe($email);

            if ($response->id) {
                $collection = collect($response);
                return response()->json($collection->only(['id', 'email_address', 'unique_email_id', 'contact_id', 'status'])->all());
            }
            else {
                return response()->json($response);
            }
        }
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }

    }

    public function newsletterUnsubscribe(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'email', 'max:255']
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }
            $email = $request->input('email');

            $response = NewsletterService::unsubscribe($email);

            if ($response->id) {
                $collection = collect($response);
                return response()->json($collection->only(['id', 'email_address', 'unique_email_id', 'contact_id', 'status'])->all());
            }
            else {
                return response()->json($response);
            }

        }
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

}
