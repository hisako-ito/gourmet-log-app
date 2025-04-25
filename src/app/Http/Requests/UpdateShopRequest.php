<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class UpdateShopRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'image' => 'nullable|mimes:png,jpeg',
            'category_id' => 'required',
            'area_id' => 'required',
            'description' => 'required|max:400',
            'courses' => 'required|array',
            'courses.*.id' => 'required|exists:courses,id',
            'courses.*.name' => 'required|max:255',
            'courses.*.price' => 'required|min:0',
            'courses.*.description' => 'required|max:400',
            'new_courses' => 'array',
            'new_courses.*.name' => 'nullable|max:255',
            'new_courses.*.price' => 'nullable|min:0',
            'new_courses.*.description' => 'nullable|max:400',
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
            'courses.required' => '1つ以上のコースを登録してください',
            'courses.*.id.required' => 'コースIDが見つかりません。再読み込みをお試しください',
            'courses.*.id.exists' => '選択されたコースが存在しません',
            'courses.*.name.required' => 'コース名を入力してください',
            'courses.*.name.string' => 'コース名は文字列で入力してください',
            'courses.*.name.max' => 'コース名は255文字以内で入力してください',
            'courses.*.price.required' => 'コースの料金を入力してください',
            'courses.*.price.integer' => 'コースの料金は整数で入力してください',
            'courses.*.price.min' => 'コース料金は0円以上で入力してください',
            'courses.*.description.required' => 'コースの詳細を入力してください',
            'courses.*.description.max' => 'コースの詳細は400文字以内で入力してください',
            'new_courses.*.name.max' => '新しいコース名は255文字以内で入力してください',
            'new_courses.*.price.min' => '新しいコースの料金は0円以上で入力してください',
            'new_courses.*.description.max' => '新しいコース詳細は400文字以内で入力してください',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $newCourses = $this->input('new_courses', []);
            $existingCourses = $this->input('courses', []);

            $hasValidNewCourse = false;
            $hasValidExistingCourse = false;

            foreach ($newCourses as $i => $course) {
                $hasAny = !empty($course['name']) || !empty($course['price']) || !empty($course['description']);

                if ($hasAny) {
                    $hasValidNewCourse = true;

                    if (empty($course['name'])) {
                        $validator->errors()->add("new_courses.$i.name", '新しいコース名を入力してください');
                    }
                    if (!isset($course['price']) || $course['price'] === '') {
                        $validator->errors()->add("new_courses.$i.price", '新しいコースの料金を選択してください');
                    }
                    if (empty($course['description'])) {
                        $validator->errors()->add("new_courses.$i.description", '新しいコースの詳細を入力してください');
                    }
                }
            }

            foreach ($existingCourses as $i => $course) {
                $isMarkedForDelete = isset($course['delete']) && $course['delete'] == '1';

                if (!$isMarkedForDelete) {
                    $hasValidExistingCourse = true;
                    break;
                }
            }

            if (!$hasValidExistingCourse && !$hasValidNewCourse) {
                $validator->errors()->add("courses", '1つ以上のコースを登録してください');
            }
        });
    }
}
