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
            'description' => 'required|max:400',
            'courses' => 'required|array',
            'courses.*.name' => 'nullable|max:255',
            'courses.*.price' => 'nullable',
            'courses.*.description' => 'nullable|max:400',
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
            'courses.required' => 'コース情報を入力してください',
            'courses.*.name.max' => 'コース名は255文字以内で入力してください',
            'courses.*.price.min' => 'コース料金は0円以上で入力してください',
            'courses.*.description.max' => 'コースの詳細は400文字以内で入力してください',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $courses = $this->input('courses', []);

            $hasValidCourse = false;

            foreach ($courses as $i => $course) {
                $hasAnyInput = !empty($course['name']) || !empty($course['price']) || !empty($course['description']);

                if ($hasAnyInput) {
                    $hasValidCourse = true;

                    if (empty($course['name'])) {
                        $validator->errors()->add("courses.$i.name", 'コース名を入力してください');
                    }

                    if (empty($course['price'])) {
                        $validator->errors()->add("courses.$i.price", 'コース料金を選択してください');
                    }

                    if (empty($course['description'])) {
                        $validator->errors()->add("courses.$i.description", 'コース詳細を入力してください');
                    }
                }
            }

            if (!$hasValidCourse) {
                $validator->errors()->add("courses", '1つ以上のコースを登録してください');
            }
        });
    }
}
