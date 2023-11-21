<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller;

use App\Http\Resources\UserCollection;
use App\Models\User;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['login','delete','checkPhone','testSendBlue',
            'loginUser','forgotPass','sendVerifyEmail','verifyResetCode','resetPass',
            'verifyPhone','resendOTP',
            'locations','register']]);
    }




    public function register(Request $request): JsonResponse
    {

        try {
            $data = $this->getData($request);

            DB::beginTransaction();



//            if($request->has('referral')){
//                $data['referral'] =
//            }

//            $data['password'] = bcrypt($data['password']);

            $data['name'] = $data['username'];

            $data['permission'] = 'user';


            $user = User::create($data);



            $user['token'] = $user->createToken($request->email)->plainTextToken;


            DB::commit();

            return $this->successResponse('Information successfully saved', $user);
        } catch (Exception $e) {
            DB::rollback();
            return $this->errorResponse($e->getMessage(), 500);
        }




//        return $this->sendVerifyEmail($request);
    }




    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:50|email|exists:users',
            'password'  => 'required|min:6'
        ], [
            'exists' => 'This email does not exist.',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Invalid credentials.',422);
        }

        try {

            if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
                $user = User::where('email', $request->email)->first();

                $data = $user;

                if($user->status == 'banned'){
                    return $this->errorResponse('Account banned, please contact support',422);
                }

                if($request['platform']){
                    $user->platform = $request['platform'];

                    $user->save();
                }

                $data['token'] = $user->createToken($request->email)->plainTextToken;
                return $this->successResponse('Login Successful', $data);

            }
            else{
                return $this->errorResponse('Invalid credentials.',422);
            }


        } catch (Exception $e) {
            // something went wrong whilst attempting to encode the token
            return $this->errorResponse('Invalid credentials.',422);

        }
    }

    public function user(Request $request): JsonResponse
    {
        $user = User::find(auth()->id());

        if($request->has('push_token')){
            $user->push_token = $request['push_token'];
            $user->save();
        }

        return  $this->successResponse('user details',$user);
    }



    public function update(Request $request): JsonResponse
    {
        $data = $this->updateData($request);
        $user = user::find(auth()->user()->id);
        $message = "Account updated";

        return $this->successResponse($message, $user);
    }


    public function updateToken(Request $request): JsonResponse
    {
        $user = user::find(auth()->user()->id);
        $user->push_token = $request['push_token'];
        $user->save();
        return $this->successResponse('push_token updated',$user);
    }


    public function logout(): JsonResponse
    {
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }


    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'user' => $this->guard('api')->user(),
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }


    public function changePassword(Request $request): JsonResponse
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6',
        ]);

        if (!(Hash::check($request->get('current_password'), auth()->user()->password))) {
            // The passwords matches
            return $this->errorResponse('Your current password does not match with the password you provided. Please try again.', 500);
        }
        if(strcmp($request->get('current_password'), $request->get('new_password')) == 0){
            //Current password and new password are same
            return $this->errorResponse('New Password cannot be same as your current password. Please choose a different password', 500);
        }

        //Change Password
        $user = auth()->user();
        $user->password = bcrypt($request->get('new_password'));
        $user->save();
        return $this->successResponse('password successfully updated', $user);
    }

    public function guard() {
        return \Auth::Guard('api');
    }

    protected function getData(Request $request)
    {
        $rules = [
            'username' => 'required|max:50|min:3|unique:users,name',
            'first_name' => 'required|max:50|min:3',
            'last_name' => 'required|max:50|min:3',
            'phone' => 'nullable',
            'email' => 'required|max:50|email|unique:users',
            'password'  => 'required|min:6',

        ];
        return $request->validate($rules);
    }
    protected function updateData(Request $request): array
    {
        $rules = [
            'first_name' => 'nullable',
            'last_name' => 'nullable',
            'region_id' => 'nullable',
            'address' => 'nullable',
            'avatar' => 'nullable',
            'file' => 'nullable',
        ];
        return $request->validate($rules);
    }

    public function destroy($id)
    {
        $user = User::destroy($id);
        return response()->json($user);
    }

    public function delete(Request $request): JsonResponse
    {
        $request->validate([
            'id' => 'required',
        ]);
        $id = $request['id'];
        $user = User::where('email', $id)->orWhere('id', $id)->first();

        if(!$user){
            return $this->errorResponse('User doesnt exist');
        }
        $user->email = $user->email.'__';
        $user->phone = $user->phone.'__';
        $user->save();
        $user->delete();
        return $this->successResponse('User deleted', $user);
    }

    public function testSendBlue(){
        $user = User::where("email", "benjaminchukwudi0@gmail.com")->first();
        return $this->addUserToSendinblue($user, $user->getRoles()[0]);
//        return $user->getRoles()[0];
    }

}
