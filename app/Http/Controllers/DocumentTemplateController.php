<?php

namespace App\Http\Controllers;

use App\Models\DocumentTemplate;
use Illuminate\Http\Request;

class DocumentTemplateController extends Controller
{
    public function index()
    {
        $templates = DocumentTemplate::latest()->paginate(15);

        return view('templates.index', compact('templates'));
    }

    public function create()
    {
        return view('templates.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'type' => ['required', 'in:offer_letter,appointment_letter,experience_letter'],
            'subject' => ['nullable', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'placeholders' => ['nullable', 'array'],
        ]);

        DocumentTemplate::create($data);

        return redirect()->route('templates.index');
    }

    public function show(DocumentTemplate $template)
    {
        return view('templates.show', compact('template'));
    }

    public function edit(DocumentTemplate $template)
    {
        return view('templates.edit', compact('template'));
    }

    public function update(Request $request, DocumentTemplate $template)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'type' => ['required', 'in:offer_letter,appointment_letter,experience_letter'],
            'subject' => ['nullable', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'placeholders' => ['nullable', 'array'],
        ]);

        $template->update($data);

        return redirect()->route('templates.index');
    }

    public function destroy(DocumentTemplate $template)
    {
        $template->delete();

        return redirect()->route('templates.index');
    }
}
