<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => [
                'required',
                "regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_])/",
                'min:8',
                'max:255'
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
            'unique' => ':attribute đã tồn tại.',
            'email' => ':attribute sai định dạng.',
            'min' => 'Độ dài phải lớn hơn :min.',
            'max' => 'Độ dài không được vượt quá :max.',
            'avatar.max' => ':attribute không được vượt quá :max.',
            'file' => ':attribute sai định dạng.',
            'mimes' => ':attribute chỉ được hỗ trợ kiểu :mimes.',
            'regex' => ':attribute không đúng định dạng.',

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
            'password' => 'Mật khẩu',
            'avatar' => 'Ảnh đại diện',
        ];
    }
}
