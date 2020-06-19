<?php

namespace App\Http\Requests;

use App\Player;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StorePlayerRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'email'    => [
                'required',
                'unique:players',
            ],
            'password' => [
                'required',
            ],
            'first_name' => [
                'required',
            ],
            'last_name' => [
                'required',
            ],
            'birthday' => [
                'required',
            ],
//            'credits' => [
//                'required',
//            ],
        ];
    }
}
