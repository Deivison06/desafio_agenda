<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Contacts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContactsController extends Controller
{

    public function index()
    {
        $contacts = Contacts::all();
        return Inertia::render('Dashboard', ['contacts' => $contacts]);
    }

    public function create()
    {
        return Inertia::render('Contacts/Create');
    }

    public function store(Request $request)
    {
        $contactData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:contacts',
            'phone' => 'nullable|string|max:20',
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('fotos', 'public');
            $contactData['foto'] = $fotoPath;
        }

        Contacts::create($contactData);

        return redirect()->route('dashboard')->with('success', 'Contato criado com sucesso!');
    }

    public function show(Contacts $contact)
    {
        return Inertia::render('Contacts/Show', ['contact' => $contact]);
    }

    public function edit(Contacts $contact)
    {
        return Inertia::render('Contacts/Edit', ['contact' => $contact]);
    }

    public function update(Request $request, Contacts $contact)
    {
        $contactData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:contacts,email,' . $contact->id,
            'phone' => 'nullable|string|max:20',
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
                Storage::disk('public')->delete($contact->foto);
            $fotoPath = $request->file('foto')->store('fotos', 'public');
            $contactData['foto'] = $fotoPath;
        }
        $contact->update($contactData);
        return redirect()->route('dashboard');
    }

    public function destroy(Contacts $contact)
    {
        $contact->delete();
        Storage::disk('public')->delete($contact->foto);
        return redirect()->route('dashboard');
    }
}
