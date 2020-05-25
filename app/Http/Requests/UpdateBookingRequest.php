<?php

namespace App\Http\Requests;

use App\Match;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateBookingRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'match_id' => [
                'required',
            ],
            'user_id' => [
                'required',
            ],
        ];
    }
}
