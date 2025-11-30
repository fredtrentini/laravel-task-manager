<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        $task = $this->route('task') ?? null;

        if ($this->isMethod('PUT')) {
            return $this->user()->can('update', $task);
        }

        if ($this->isMethod('DELETE')) {
            return $this->user()->can('delete', $task);
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
            'due_date' => 'required|date',
            'priority' => 'required|integer|between:1,5',
            'file' => [
                $this->isMethod('POST') ? 'required' : 'nullable',
                'file',
                'mimes:pdf',
                'max:2048'
            ],
        ];
    }
}
