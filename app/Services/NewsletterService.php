<?php

namespace App\Services;

use App\Mail\NewsletterRegistrationEmail;
use Illuminate\Support\Facades\Mail;
use MailchimpMarketing\ApiClient;

class NewsletterService
{
    public static function subscribe($email) {
        $listId = env('MAILCHIMP_LIST_ID');
        $apiKey = env('MAILCHIMP_API_KEY');
        $apiKeyParts = explode('-', $apiKey);
        $serverPrefix = array_pop($apiKeyParts);
        $email_hash = md5($email);

        $client = new ApiClient();
        $client->setConfig([
            'apiKey' => $apiKey,
            'server' => $serverPrefix,
        ]);

        $response = $client->lists->setListMember($listId, $email_hash, [
            "email_address" => $email,
            "status_if_new" => "subscribed",
        ]);

        if ($response->id) {
            // send welcome email
            static::sendWelcomeEmail($email);
        }

        return $response;
    }

    public static function unsubscribe($email) {
        $listId = env('MAILCHIMP_LIST_ID');
        $apiKey = env('MAILCHIMP_API_KEY');
        $apiKeyParts = explode('-', $apiKey);
        $serverPrefix = array_pop($apiKeyParts);
        $email_hash = md5($email);

        $client = new ApiClient();
        $client->setConfig([
            'apiKey' => $apiKey,
            'server' => $serverPrefix,
        ]);

        $response = $client->lists->setListMember($listId, $email_hash, [
            "email_address" => $email,
            "status_if_new" => "unsubscribed",
            'status' => 'unsubscribed'
        ]);

        return $response;
    }

    public static function sendWelcomeEmail($email) {
        $mail = new NewsletterRegistrationEmail($email);
        return Mail::to([$email])->send($mail);
    }

    public static function sendNewsletter($email) {

    }
}
