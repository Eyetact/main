<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Admin\MList;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use PhpParser\Node\NullableType;



class AuthController extends Controller
{
    use ResponseTrait;

    /**
     * @var UserRepository
     */
    protected $userRepositry;

    public function __construct()
    {
        $this->userRepositry = new UserRepository(app(User::class));
    }

    public function login(AuthRequest $request)
    {

        if (
            !Auth::attempt(
                $request->only([
                    'username',
                    'password',
                ])
            )
        ) {
            return response()->json([
                'status' => false,
                'code' => 500,
                'msg' => __('Invalid credentials!'),
            ], 500);
        }

        $check = User::where('username', $request->username)
            ->first();

        if (!($check->hasRole('vendor'))) {

            return $this->returnError('Invalid credentials!');
        }

        $accessToken = Auth::user()->createToken('authToken')->accessToken;

        return response([
            'status' => true,
            'code' => 200,
            'msg' => __('Log in success'),
            'data' => [
                'token' => $accessToken,
                'user' => UserResource::make(Auth::user()),
            ]
        ]);

    }


    public function store(UserRequest $request)
    {
        try {

            DB::beginTransaction();


            $serial = MList::where('m_serial', $request->serial_number)
                ->first();


            if (!$serial) {

                return $this->returnError('The serial number not correct!');
            }

            if ($serial->customer_id) {

                $vendor = User::find($serial->customer_id);
                $user = User::where('email', $request->email)
                 ->first();

                 if ($user) {

                    if ($vendor->id == $user->id) {
                        if(Hash::check($request->password, $user->password)) {

                        // dd($user);


                            Auth::login($vendor);

                            $accessToken = Auth::user()->createToken('authToken')->accessToken;

                            return response([
                                'status' => true,
                                'code' => 200,
                                'msg' => __('Log in success'),
                                'data' => [
                                        'token' => $accessToken,
                                        'user' => UserResource::make(Auth::user()),
                                    ]
                            ]);
                        }
                    }
                }
                return $this->returnError('The data not valid!');


            }

            if ($serial->customer_id == NULL) {


                if (isset($request->email)) {
                    $check = User::where('email', $request->email)
                        ->first();

                    if ($check) {

                        return $this->returnError('The email address is already used!');
                    }
                }

                $user = $this->userRepositry->save($request);
                $user->assignRole('vendor');


                DB::commit();
                Auth::login($user);

                $accessToken = Auth::user()->createToken('authToken')->accessToken;

                if ($user) {

                    $serial->customer_id = $user->id;
                    $serial->save();

                    return response([
                        'status' => true,
                        'code' => 200,
                        'msg' => __('User created succesfully'),
                        'data' => [
                                'token' => $accessToken,
                                'user' => UserResource::make(Auth::user()),
                            ]
                    ]);
                }

            }
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            return $this->returnError('Sorry! Failed in creating user');
        }
    }




}
