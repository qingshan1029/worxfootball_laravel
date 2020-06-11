<?php

namespace App\Http\Requests;

use App\Bonus;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreBonusRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'from_date' => [
                'required',
            ],
            'to_date' => [
                'required',
            ],
            'amount' => [
                'required',
            ],
            'active' => [
                'required',
            ],
        ];
    }
}
