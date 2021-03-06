<?php

namespace App\Http\Requests;

use App\Booking;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreBookingRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'match_id' => [
                'required',
            ],
            'player_id' => [
                'required',
            ],
        ];
    }
}
