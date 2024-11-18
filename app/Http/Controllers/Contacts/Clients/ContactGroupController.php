<?php

namespace App\Http\Controllers\Contacts\Clients;

use App\DataTables\ContactGroupDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactGroup;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use App\Models\ContactGroup;
use App\Support\Phone\PhoneService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class ContactGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ContactGroupDatatable $dataTable)
    {
        return $dataTable->render('client.contact.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('client.contact.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContactGroup $request)
    {
        $requestBody = $request->validated();

        auth()
            ->user()
            ->contactGroups()
            ->create($requestBody);

        return redirect()->route('contacts.groups.index')->with('message', 'Conact group created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contactGroup = ContactGroup::withCount('contacts')->find($id);

        return view('client.contact.showContacts', ['contact_group' => $contactGroup]);
    }

    public function datatable($id, DataTables $dataTables)
    {
        $contact = ContactGroup::with('contacts')
            ->withCount('contacts')
            ->findOrFail($id)
            ->contacts;

        return $dataTables->collection($contact)
            ->addColumn('actions', function ($contact) {
                return view('client.contact.table.showContacts-actions', ['query' => $contact])
                    ->render();
            })
            ->rawColumns(['actions'])
            ->toJson();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreContactGroup $request, $id)
    {
        $contactGroup = ContactGroup::findOrFail($id);

        $this->authorize('update', $contactGroup);

        $contactGroup->update($request->validated());

        return redirect()->back()->with('success', 'Contact group edit successful');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contactGroup = ContactGroup::findOrFail($id);
        $contactGroup->delete();

        return redirect()->back()->with('success', 'Contact group deleted');
    }

    public function addContact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|min:7',
            'name' => 'sometimes|nullable|string',
            'email' => 'sometimes|nullable|email',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        Contact::create([
            'phone' => $request->input('phone'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'contact_group_id' => $request->input('contact_group_id'),
        ]);

        return redirect()->back();
    }

    public function editContact(UpdateContactRequest $request, $id)
    {
        $contact = Contact::with('contactGroup')->findOrFail($id);

        $this->authorize('update', $contact);

        $contact->update(
            $request->safe()
                ->merge([
                    'phone' => (new PhoneService)->formatPhoneNumberWithoutPlusSign($request->phone),
                ])
                ->toArray()
        );

        return redirect()->back()->with('success', 'Contact edit successful');
    }

    public function deleteContact($id)
    {
        $contactGroup = Contact::findOrFail($id);
        $contactGroup->delete();

        return redirect()->back()->with('success', 'Contact deleted');
    }
}
