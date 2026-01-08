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
            'whatsapp_country' => ['required','string','max:10'],
            'whatsapp_phone'   => ['required','string','max:30'],
            'email'            => ['nullable','email','max:255'],
            'name'             => ['nullable','string','max:255'],
            'consent'          => ['accepted'], // ต้องติ๊กเท่านั้น
            'source'           => ['nullable','string','max:50'],
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
