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
            'product_name' => 'required|string|regex:/^[a-zA-Z0-9\s\-_,.()]+$/',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ];

        // Only require index for update operations
        if ($this->isMethod('put')) {
            $rules['index'] = 'required|integer';
        }

        return $rules;
    }

    /**
     * Get custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'product_name.required' => 'The product name field is required.',
            'product_name.string' => 'The product name must be a valid text.',
            'product_name.regex' => 'The product name contains invalid characters. Only letters, numbers, spaces, hyphens, underscores, commas, periods, and parentheses are allowed.',
            
            'quantity.required' => 'The quantity field is required.',
            'quantity.integer' => 'The quantity must be a whole number.',
            'quantity.min' => 'The quantity cannot be negative.',
            
            'price.required' => 'The price field is required.',
            'price.numeric' => 'The price must be a valid number.',
            'price.min' => 'The price cannot be negative.',
            
            'index.required' => 'The product index is required for updates.',
            'index.integer' => 'The product index must be a valid number.',
        ];
    }

    /**
     * Get the validated data with additional fields.
     *
     * @return array<string, mixed>
     */
    public function validatedData(): array
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