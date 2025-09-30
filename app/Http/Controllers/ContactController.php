<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Show the contact form.
     */
    public function create()
    {
        return view('contact.create');
    }

    /**
     * Handle form submission.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email',
            'subject' => 'required|string|max:150',
            'message' => 'required|string|max:2000',
        ]);

        $contact = Contact::create([
            'name'    => $validated['name'],
            'email'   => $validated['email'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'ip'      => $request->ip(),
        ]);

        try {
            // Check if mail is not configured or empty
            if (empty(config('mail.mailers.smtp.host')) || empty(config('mail.from.address'))) {
                return redirect()->route('contact.create')->with('error', 'Email service is not configured. Please set up your mail credentials in the .env file.');
            }

            // Check if admin email is not set or empty
            if (empty(env('MAIL_ADMIN'))) {
                return redirect()->route('contact.create')->with('error', 'Admin email is not configured. Please set MAIL_ADMIN in your .env file.');
            }

            //If Everything is fine then send email
            Mail::to(env('MAIL_ADMIN'))->send(new ContactMail($contact));

            return redirect()->route('contact.create')->with('success', 'Thank you for reaching out to us. We’ve received your details and our team will get back to you as soon as possible.');
        } catch (\Exception $e) {
            return redirect()->route('contact.create')->with('error', 'An unexpected error occurred while sending your message. Please try again later.');
        }
    }
}
