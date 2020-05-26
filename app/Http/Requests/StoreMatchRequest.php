<?php

namespace App\Http\Requests;

use App\Match;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreMatchRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('match_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
//            'host_photo'    => [
//                'required',
//            ],
            'host_name' => [
                'required',
            ],
            'title' => [
                'required',
            ],
            'start_time' => [
                'required',
            ],
            'address' => [
                'required',
            ],
            'reservations' => [
                'required',
            ],
            'rules' => [
                'required',
            ],
            'credits' => [
                'required',
            ],
        ];
    }
}
