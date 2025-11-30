<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        $task = $this->route('task') ?? null;

        if ($this->isMethod('PATCH')) {
            return $this->user()->can('update', $task);
        }

        if ($this->isMethod('DELETE')) {
            return $this->user()->can('delete', $task);
        }

        return true;
    }

    public function rules(): array
    {
        if (!$this->isMethod('POST') && !$this->isMethod('PATCH')) {
            return [];
        }

        $requirement_rule = $this->isMethod('POST') ? 'required' : 'sometimes';

        return [
            'title' => [$requirement_rule, 'string', 'max:255'],
            'description' => [$requirement_rule, 'string'],
            'due_date' => [$requirement_rule, 'date'],
            'priority' => [$requirement_rule, 'integer', 'between:1,5'],
            'status' => ['sometimes', 'integer', 'between:1,3'],
            'file' => [
                $requirement_rule,
                'file',
                'mimes:pdf',
                'max:2048'
            ],
        ];
    }
}
