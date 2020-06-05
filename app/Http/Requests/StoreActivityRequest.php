<?php

namespace App\Http\Requests;

use App\Activity;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreActivityRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'player_id' => [
                'required',
            ],
            'type' => [
                'required',
            ],
            'content' => [
                'required',
            ],
        ];
    }
}
