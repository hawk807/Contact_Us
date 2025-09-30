<?php

namespace Tests\Feature;

use App\Mail\ContactMail;
use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactFunctionalityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_saves_message_in_database_and_sends_email()
    {
        Mail::fake();
    
        config(['mail.admin' => 'ameerhamza.oa@gmail.com']);

        $data = [
            'name' => 'Ameer Hamza',
            'email' => 'ameerhamza.oa@gmail.com',
            'subject' => 'Test Email Subject',
            'message' => 'This is a test message',
        ];

        $response = $this->post(route('contact.store'), $data);

        $this->assertDatabaseHas('contacts', [
            'name' => 'Ameer Hamza',
            'email' => 'ameerhamza.oa@gmail.com',
            'subject' => 'Test Email Subject',
            'message' => 'This is a test message',
        ]);

        Mail::assertSent(ContactMail::class, function ($mail) use ($data) {
            dd($data['email']);
            dd($mail->contact->email);
            return $mail->contact->email === $data['email'];
        });

        $response->assertRedirect(route('contact.create'));
        $response->assertSessionHas('success');
    }

    /** @test */
    public function it_fails_validation_when_required_fields_are_missing()
    {
        Mail::fake();

        $response = $this->post(route('contact.store'), []);
        $response->assertSessionHasErrors(['name', 'email', 'subject', 'message']);
        $this->assertDatabaseCount('contacts', 0);

        Mail::assertNothingSent();
    }
}
