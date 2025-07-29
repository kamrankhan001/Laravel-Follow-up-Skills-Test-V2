<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        $rules = [
            'product_name' => 'required|string',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ];

        // Only require index for update operations
        if ($this->isMethod('put')) {
            $rules['index'] = 'required|integer';
        }

        return $rules;
    }

     public function validatedData()
    {
        $validated = $this->validated();
        
        return [
            'product_name' => $validated['product_name'],
            'quantity' => (int) $validated['quantity'],
            'price' => (float) $validated['price'],
            'submitted_at' => now()->toDateTimeString(),
            'total_value' => (float) $validated['quantity'] * $validated['price'],
        ];
    }
}
