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
            'new_courses' => 'array',
            'courses.*.id' => 'required|exists:courses,id',
            'courses.*.name' => 'required|string|max:255',
            'courses.*.price' => 'required|integer|min:0',
            'courses.*.description' => 'required|max:400',
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
            'courses.*.id.required' => 'コースIDが見つかりません。再読み込みをお試しください',
            'courses.*.id.exists' => '選択されたコースが存在しません',
            'courses.*.name.required' => '各コース名を入力してください',
            'courses.*.name.string' => 'コース名は文字列で入力してください',
            'courses.*.name.max' => 'コース名は255文字以内で入力してください',
            'courses.*.price.required' => '各コースの料金を入力してください',
            'courses.*.price.integer' => 'コースの料金は整数で入力してください',
            'courses.*.price.min' => 'コース料金は0円以上で入力してください',
            'courses.*.description.required' => '各コースの詳細を入力してください',
            'courses.*.description.required' => '各コースの詳細は400文字以内で入力してください',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $courses = $this->input('courses', []);
            $newCourses = $this->input('new_courses', []);

            $remainingCourses = array_filter($courses, function ($course) {
                return empty($course['delete']);
            });

            $newCourses = array_filter($newCourses, function ($course) {
                return !empty($course['name']) && !empty($course['price']);
            });

            if (count($remainingCourses) + count($newCourses) === 0) {
                $validator->errors()->add('courses', 'コースは1件以上必要です。');
            }
        });
    }
}
