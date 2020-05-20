<?php

namespace App\Http\Requests;

use App\Model\HistoryOrder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderMethodRequest extends FormRequest
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
            'cartridge' => Rule::in([HistoryOrder::NEW_CARTRIDGE, HistoryOrder::SEASONED_CARTRIDGE])
        ];
    }
}
