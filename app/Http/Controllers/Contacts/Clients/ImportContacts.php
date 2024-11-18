<?php

namespace App\Http\Controllers\Contacts\Clients;

use App\Http\Controllers\Controller;
use App\Imports\ContactsImport;
use App\Jobs\NotifyUserOfCompletedContactsImport;
use App\Models\ContactGroup;
use Illuminate\Http\Request;

class ImportContacts extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, int $id)
    {
        $request->validate([
            'contacts' => [
                'required',
                'file',
            ],
        ]);

        (new ContactsImport(auth()->user(), $id))
            ->queue($request->file('contacts'))
            ->chain([
                new NotifyUserOfCompletedContactsImport(auth()->user(), $id),
            ]);

        return redirect()->route('contacts.groups.show', $id)
            ->with('message', 'You will receive an SMS alert when contacts have finished importing');
    }

    public function importView($id)
    {
        $contact_group = ContactGroup::with(['contacts'])->findOrFail($id);

        return view('client.contact.importContacts', ['page-title' => 'Import Contacts', 'contact_group' => $contact_group]);
    }

    public function downloadContactSampleFile()
    {
        return response()->download('assets/files/contacts_import.csv');
    }
}
