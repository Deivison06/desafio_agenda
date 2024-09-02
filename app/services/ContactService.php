<?php

namespace App\Services;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ContactsRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateContactsRequest;
use Illuminate\Support\Facades\Auth;

class ContactService
{
    public function __construct(protected Contact $contact) {}

    public function list(Request $request)
    {
        $contacts = Auth::user()->contacts()
            ->when($request->search, function ($query, $search) {
                $query->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            })
            ->paginate(10)
            ->withQueryString();

        return $contacts;
    }
    public function store(ContactsRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $contactData = $request->except('foto');

            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('fotos', 'public');
                $contactData['foto'] = $fotoPath;
            }
            $contactData['user_id'] = Auth::id();
            dd($request->all());
            return $this->contact->create($contactData);
        });
    }
    public function update(UpdateContactsRequest $request, Contact $contact)
    {
        return DB::transaction(function () use ($request, $contact) {
            $contactData = $request->validated();

            $contact->update($contactData);

            return redirect()->route('dashboard')->with('success', 'Contato atualizado com sucesso!');
        });
    }
    public function destroy(Contact $contact)
    {
        return DB::transaction(function () use ($contact) {
            $contact->delete();
            if ($contact->foto) {
            Storage::disk('public')->delete($contact->foto);
        }
        });
    }
}
