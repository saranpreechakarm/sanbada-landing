<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'whatsapp_country' => ['required','string','regex:/^\+[1-9][0-9]{0,3}$/'],
            'whatsapp_phone'   => ['bail','required','string','max:30','regex:/^[+0-9 ()\-.]+$/', function ($attribute, $value, $fail) {
                $length = strlen(preg_replace('/[^0-9]/', '', $value));
                if ($length < 6 || $length > 15) $fail(app()->getLocale() === 'ru' ? 'Проверьте номер телефона.' : 'Please check your phone number.');
            }],
            'email'            => ['nullable','email','max:255'],
            'name'             => ['nullable','string','max:255'],
            'consent'          => ['accepted'],
            'purpose' => ['nullable', \Illuminate\Validation\Rule::in(['living', 'investment'])],
            'budget_range' => ['nullable', \Illuminate\Validation\Rule::in(['under5', '5to10', 'over10'])],
            'preferred_area' => ['nullable', 'string', 'max:255'],
            'source'           => ['nullable','string','max:50'],

            // ✅ เพิ่ม
            'project' => ['nullable','string','max:255'],
            'project_id' => ['nullable', 'integer', \Illuminate\Validation\Rule::exists('projects', 'id')->where('is_published', true)->whereNull('deleted_at')],
            'pdf'     => ['nullable','string','max:500','starts_with:assets/projects/pdf/,content/brochures/'],
            'company_website' => ['nullable', 'string', 'max:0'],
            'utm_source' => ['nullable','string','max:255'], 'utm_medium' => ['nullable','string','max:255'],
            'utm_campaign' => ['nullable','string','max:255'], 'utm_content' => ['nullable','string','max:255'], 'utm_term' => ['nullable','string','max:255'],
        ];
    }

    public function messages(): array
    {
        // ข้อความ error เป็นรัสเซีย
        return [
            'whatsapp_phone.required' => 'Введите телефон.',
            'consent.accepted'        => 'Необходимо согласие на обработку персональных данных.',
            'email.email'             => 'Введите корректный email.',
        ];
    }
}
