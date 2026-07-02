<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $query = Contact::query();

        if ($status && in_array($status, ['unread', 'read', 'replied'])) {
            $query->where('status', $status);
        }

        $contacts = $query->latest()->paginate(15)->withQueryString();

        return view('admin.contacts.index', compact('contacts', 'status'));
    }

    public function show(Contact $contact)
    {
        if ($contact->status === 'unread') {
            $contact->update(['status' => 'read']);
        }

        return view('admin.contacts.show', compact('contact'));
    }

    public function updateStatus(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:unread,read,replied'],
        ], [
            'status.required' => 'Status tidak boleh kosong.',
            'status.in'       => 'Status harus salah satu dari: unread, read, replied.',
        ]);

        $contact->update(['status' => $validated['status']]);

        return redirect()->route('admin.contacts.show', $contact->id)
            ->with('success', 'Status pesan berhasil diperbarui.');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Pesan berhasil dihapus.');
    }
}
