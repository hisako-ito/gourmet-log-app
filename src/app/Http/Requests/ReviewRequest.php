<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;


class ReviewRequest extends FormRequest
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
        Log::debug('ReviewRequest input:', $this->all()); // ★ここ！
        return [
            'rating' => ['nullable', 'integer'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages()
    {
        return [
            'rating.integer' => '評価は数字で指定してください',
            'comment.string' => 'コメントは文字列で入力してください',
            'comment.max' => 'コメントは1000文字以内で入力してください',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $rating = $this->input('rating');
            $comment = $this->input('comment');

            if (empty($rating) && empty(trim($comment))) {
                $validator->errors()->add('comment', '評価またはコメントのいずれかを入力してください。');
            }
        });
    }
}
