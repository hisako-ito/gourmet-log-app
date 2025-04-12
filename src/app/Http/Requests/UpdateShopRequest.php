<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShopRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'image' => 'nullable|mimes:png,jpeg',
            'category_id' => 'required',
            'area_id' => 'required',
            'description' => 'required|max:400',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '店舗名を入力してください',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
            'category_id.required' => 'カテゴリーを選択してください',
            'area_id.required' => 'エリアを選択してください',
            'description.required' => '店舗詳細を入力してください',
            'description.max' => '本文は400文字以内で入力してください',
        ];
    }
}
