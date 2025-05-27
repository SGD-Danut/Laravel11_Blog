<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactMessage;
use App\Http\Requests\AddContactMessageRequest;
use Illuminate\Support\Facades\Mail;

class ContactMessageController extends Controller
{
    public function newContactMessageForm() {
        return view('front.contact');
    }

    public function createNewContactMessage(AddContactMessageRequest $request) {
        $message = new ContactMessage();

        $message->name = $request->name;
        $message->email = $request->email;
        $message->subject = $request->subject;
        $message->category = $request->category;
        $message->message = $request->message;

        $message->save();

        // Trimitem un email administratorului blogului:
        Mail::send('email.new-contact-message', [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'category' => $request->category,
            'messageContent' => $request->message
        ], function($m) use($request) {
            $m->from($request->email);
            $m->to('system@blog.com')->subject('Un nou mesaj de contact. Răspundeți în cel mai scurt timp!');
        });

        return back()->with('success', 'Mesajul dumneavoastră a fost trimis! Vă vom răspunde cât mai repede posibil.');
    }
}
