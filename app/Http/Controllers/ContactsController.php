<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Services\ContactService;
use App\Http\Requests\ContactsRequest;
use App\Http\Requests\UpdateContactsRequest;

class ContactsController extends Controller
{
    public function __construct(protected ContactService $contactService)
    {}

    public function index(Request $request)
    {
        $contacts = $this->contactService->list($request);
        return inertia('Dashboard', [
            'contacts' => $contacts,
            'search' => $request->search,
        ]);
    }
    public function create()
    {
        return Inertia::render('Contacts/Create');
    }

    public function store(ContactsRequest $request)
    {
        $contact = $this->contactService->store($request);

        return redirect()->route('dashboard')->with('success', 'Contato criado com sucesso!');
    }

    public function show(Contact $contact)
    {
        return Inertia::render('Contacts/Show', ['contact' => $contact]);
    }

    public function edit(Contact $contact)
    {
        return Inertia::render('Contacts/Edit', ['contact' => $contact]);
    }

    public function update(UpdateContactsRequest $request, Contact $contact)
    {
        $contact = $this->contactService->update($request, $contact);
        return redirect()->route('dashboard');
    }

    public function destroy(Contact $contact)
    {
        $this->contactService->destroy($contact);
        return redirect()->route('dashboard');
    }
}
