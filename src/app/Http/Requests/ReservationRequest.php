<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class ReservationRequest extends FormRequest
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
        $tomorrow = Carbon::tomorrow()->format('Y-m-d');

        return [
            'date' => ['required', 'after_or_equal:' . $tomorrow],
            'time' => ['required'],
            'course_id' => ['required'],
            'number' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'date.required' => '日付を選択してください',
            'date.after_or_equal' => '明日以降の日付を入力してください',
            'time.required' => '時間を選択してください',
            'course_id.required' => 'コースを選択してください',
            'number.required' => '人数を選択してください',
        ];
    }
}
