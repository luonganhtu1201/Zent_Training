<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->id,
        ]);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => [
                'required',
                'integer',
                Rule::exists('users', 'id')
                    ->whereNull('deleted_at')
            ],
            'name' => ['required'],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')
                    ->ignore($this->id, 'id')
            ],
            'avatar' => [
                'nullable',
                'file',
                'max:2048',
                'mimes:jpg,jpeg,png,svg,JPG,JPEG,PNG,gif,webp'
            ]
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'required' => ':attribute không được bỏ trống.',
            'integer' => ':attribute phải là số nguyên.',
            'exists' => ':attribute không tồn tại.',
            'unique' => ':attribute đã tồn tại.',
            'email' => ':attribute sai định dạng.',
            'min' => 'Độ dài phải lớn hơn :min.',
            'max' => 'Độ dài không được vượt quá :max.',
            'avatar.max' => ':attribute không được vượt quá :max.',
            'file' => ':attribute sai định dạng.',
            'mimes' => ':attribute chỉ được hỗ trợ kiểu :mimes.',

        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'id' => 'Tài khoản',
            'name' => 'Tài khoản',
            'email' => 'Email',
            'avatar' => 'Ảnh đại diện',
        ];
    }
}
