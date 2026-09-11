<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'company' => ['nullable', 'string', 'max:160'],
            'email' => ['required', 'email:rfc', 'max:254'],
            'phone' => ['nullable', 'string', 'max:40'],
            'service' => ['required', Rule::in(['import', 'export', 'logistics', 'supply', 'other'])],
            'message' => ['required', 'string', 'min:20', 'max:5000'],
            'consent' => ['accepted'],
            'website' => ['prohibited'],
        ];
    }

    public function attributes(): array
    {
        return __('site.form.attributes');
    }

    protected function getRedirectUrl(): string
    {
        if ($this->route('page') === 'home') {
            return route(app()->getLocale().'.home').'#contact';
        }

        return parent::getRedirectUrl();
    }
}
