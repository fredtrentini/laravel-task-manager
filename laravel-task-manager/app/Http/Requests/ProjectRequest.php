<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        $project = $this->route('project') ?? null;

        if ($this->isMethod('PUT')) {
            return $this->user()->can('update', $project);
        }

        if ($this->isMethod('DELETE')) {
            return $this->user()->can('delete', $project);
        }

        return true;
    }

    public function rules(): array
    {
        if (!$this->isMethod('POST') && !$this->isMethod('PUT')) {
            return [];
        }

        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ];
    }
}
