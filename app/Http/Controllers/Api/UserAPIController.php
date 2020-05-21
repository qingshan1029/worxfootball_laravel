<?php
namespace App\Http\Controllers\Api;
use App\Http\Resources\Admin\UserResource;
use App\Player;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Validator;

class UserAPIController extends Controller
{
    public $successStatus = 200;
    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login() {
        $request = ['email' => request('email'), 'password' => request('password')];

        $validator = Validator::make($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails($request)) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        if (auth()->attempt($request)) {
            // Authentication passed...
            $user = auth()->user();
            $user->remember_token = $user->createToken('MyApp')-> accessToken;
            $success['remember_token'] = $user->remember_token;
//            $user->save();
            return response()->json(['user' => $user], $this-> successStatus);
        }
        else {
            return response()->json(['error'=>'Unauthenticated user'], 401);
        }
    }
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => [
                'required',
                'unique:users',
            ],
            'password' => [
                'required',
            ],
            'name' => [
                'required',
            ],
        ]);

        if ($validator->fails($request)) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $user = User::where('email','=',$request['email']);
        if( $user->count()) {
            return response()->json(['error'=>'The email exist already.'], 401);
        }

        $user = User::create($request->all());
        $success['email'] =  $user->email;
        return response()->json(['user'=>$user], $this-> successStatus);
    }
    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function users()
    {
        $users = User::all();
        return response()->json(['user' => $users], $this-> successStatus);
    }
}
