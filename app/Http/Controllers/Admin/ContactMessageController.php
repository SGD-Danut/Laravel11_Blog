<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function showContactMessages() {
        $contactMessages = ContactMessage::all()->sortByDesc('created_at');
        $title = 'Mesaje de contact';
        return view('admin.contact-messages.contact-messages')->with('contactMessages', $contactMessages)->with('title', $title);;
    }

    public function deleteContactMessage($contactMessageId) {
        $contactMessage = ContactMessage::findOrFail($contactMessageId);
        $contactMessage->delete();
        return back()->with('success', 'Mesajul a fost șters!');
    }    
}
