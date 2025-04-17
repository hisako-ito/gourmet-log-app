<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreShopRequest extends FormRequest
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
            'image' => 'required|mimes:png,jpeg',
            'category_id' => 'required',
            'area_id' => 'required',
            'courses' => 'array',
            'description' => 'required|max:400',
            'courses.*.name' => 'required|max:255',
            'courses.*.price' => 'required|integer|min:0',
            'courses.*.description' => 'required|max:400',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '店舗名を入力してください',
            'image.required' => '店舗画像を設定してください',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
            'category_id.required' => 'カテゴリーを選択してください',
            'area_id.required' => 'エリアを選択してください',
            'description.required' => '店舗詳細を入力してください',
            'description.max' => '本文は400文字以内で入力してください',
            'courses.*.name.required' => '各コース名を入力してください',
            'courses.*.name.max' => 'コース名は255文字以内で入力してください',
            'courses.*.price.required' => '各コースの料金を入力してください',
            'courses.*.price.integer' => 'コースの料金は整数で入力してください',
            'courses.*.price.min' => 'コース料金は0円以上で入力してください',
            'courses.*.description.required' => '各コースの詳細を入力してください',
            'courses.*.description.required' => '各コースの詳細は400文字以内で入力してください',
        ];
    }
}
