<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SurveyTemplate;

class AdminTemplateController extends Controller
{
    public function index(SurveyTemplate $editingTemplate = null)
    {
        $categories = [
            'Satisfacción',
            'Evaluación',
            'Feedback',
        ];

        $templates = SurveyTemplate::orderBy('created_at', 'desc')->get();

        return view('admin.plantillas', [
            'categories' => $categories,
            'templates' => $templates,
            'editingTemplate' => ($editingTemplate && $editingTemplate->exists) ? $editingTemplate : null,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'is_mandatory' => 'nullable|boolean',
        ]);

        $template = new SurveyTemplate();
        $template->name = $data['name'];
        $template->category = $data['category'];
        $template->is_mandatory = $request->boolean('is_mandatory');
        $template->created_by = Auth::id();
        $template->structure = [];
        $template->save();

        return redirect()->route('admin.plantillas')->with('success', 'Plantilla creada correctamente.');
    }

    public function edit(SurveyTemplate $template)
    {
        return $this->index($template);
    }

    public function update(Request $request, SurveyTemplate $template)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'is_mandatory' => 'nullable|boolean',
        ]);

        $template->name = $data['name'];
        $template->category = $data['category'];
        $template->is_mandatory = $request->boolean('is_mandatory');
        $template->save();

        return redirect()->route('admin.plantillas')->with('success', 'Plantilla actualizada correctamente.');
    }

    public function destroy(SurveyTemplate $template)
    {
        $template->delete();

        return redirect()->route('admin.plantillas')->with('success', 'Plantilla eliminada.');
    }
}
