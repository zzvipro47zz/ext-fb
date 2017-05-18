<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StatusRequest extends FormRequest {
	public function authorize() {
		return true;
	}

	public function rules() {
		return [
			'image' => 'image|mimes:jpg,png,jpeg',
		];
	}

    public function messages() {
        return [
            'image.image' => 'File này không phải là hình !',
            'image.mimes' => 'File phải có extension jpg, png, jpeg',
        ];
    }
}
