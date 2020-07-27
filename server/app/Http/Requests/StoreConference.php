<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use App\Conference;

class StoreConference extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name for the Conference is required',
        ];
    }

    protected function prepareForValidation()
    {
        $slug   = Str::slug($this->name);
        $count  = Conference::where('slug', 'like', '%' . $slug . '%')->count();
        $this->merge([
            'slug' => $count >= 1 ? $slug . '-' . ($count + 1) : $slug,
        ]);
    }
}
