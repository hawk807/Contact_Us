<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class ContactController extends Controller
{
    private int $max_submissions_allowed;
    private int $time_threshold; // in minutes
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->max_submissions_allowed = 5; // max 5 submissions
        $this->time_threshold = 60;         // 60 minutes (1 hour)
    }

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
        $ip = $request->ip();
        if (RateLimiter::tooManyAttempts($ip, $this->max_submissions_allowed)) {
            return redirect()
                ->route('contact.create')
                ->with('error', "You have reached the maximum number of {$this->max_submissions_allowed} submissions allowed per {$this->time_threshold} minutes. Please try again later.");
        }
        RateLimiter::hit($ip, $this->time_threshold * 60);

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

            // Check if admin email is configured or empty
            $adminEmail = config('mail.admin');
            if (empty($adminEmail)) {
                return redirect()->route('contact.create')->with('error', 'Admin email is not configured. Please set MAIL_ADMIN in your .env file.');
            }

            //If Everything is fine then send email
            Mail::to($adminEmail)->send(new ContactMail($contact));

            return redirect()->route('contact.create')->with('success', 'Thank you for reaching out to us. We’ve received your details and our team will get back to you as soon as possible.');
        } catch (\Exception $e) {
            return redirect()->route('contact.create')->with('error', 'An unexpected error occurred while sending your message. Please try again later.');
        }
    }
}
