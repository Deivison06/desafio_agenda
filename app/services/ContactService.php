<?php

namespace App\Services;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ContactsRequest;
use Illuminate\Support\Facades\Storage;

class ContactService
{
    public function __construct(protected Contact $contact) {}

    public function list(Request $request)
    {
        $contacts = $this->contact->query()
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

            return $this->contact->create($contactData);
        });
    }
    public function update(ContactsRequest $request, Contact $contact)
    {
        return DB::transaction(function () use ($request, $contact) {
            $contactData = $request->validated();

            if ($request->hasFile('foto')) {
                // Verifique se há uma foto antiga e exclua-a
                if ($contact->foto) {
                    Storage::disk('public')->delete($contact->foto);
                }
                $fotoPath = $request->file('foto')->store('fotos', 'public');
                $contactData['foto'] = $fotoPath;
            }

            // Atualiza os dados do contato
            $contact->update($contactData);

            return redirect()->route('dashboard')->with('success', 'Contato atualizado com sucesso!');
        });
    }
    public function destroy(Contact $contact)
    {
        return DB::transaction(function () use ($contact) {
            $contact->delete();
            Storage::disk('public')->delete($contact->foto);
        });
    }
}
