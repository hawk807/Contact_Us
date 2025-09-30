<x-mail::message>
# New Contact Message

**Name:** {{ $contact->name }}  
**Email:** {{ $contact->email }}  
**Subject:** {{ $contact->subject }}  

---

{{ $contact->message }}
</x-mail::message>
