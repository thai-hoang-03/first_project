<?php
namespace App\Http\Controllers;
use App\Http\Requests\api\LoginRequest;
use App\Http\Requests\api\UpdateProfileRequest;
use App\Http\Requests\api\UserRequest;
use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{
   public $successStatus = 200;

   //Handle Login for user
   public function login(LoginRequest $request)
    {
        $dataLogin = [
            'email' => $request->email,
            'password' => $request->password,
            'level' => 0
        ];

        $remember = false;
        if($request->remember_me){
            $remember = true;
        };

        if(Auth::attempt($dataLogin, $remember)){
            $user = Auth::user();
            // Log::info('User sau khi đăng nhập:', [$user]); 

            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'success' => 'success',
                'token' => $token, 
                'Auth' => $user
            ], 
            $this->successStatus);
        }else{
            return response()->json([
                'response' => 'error',
                'errors' => ['errors' => 'invalid email or password'],
            ],
            $this->successStatus); 
        }

    }
    
    //Handle register for user
    public function register(UserRequest $request)
    {
        $data = $request->all();

        $data['password'] = bcrypt($data['password']);  //Xử lý password
    
        $avatar = $request->hasFile('avatar');    //Kiểm tra xem trong request gửi lên có file avatar hay không
        if($avatar){
            $image = $request->file('avatar'); //Lấy file avatar
            $data['avatar'] = $image->getClientOriginalName();
        }

        if ($getUser = User::create($data)) {
            if($avatar){
                $image->move('upload/user/avatar', $image->getClientOriginalName());
            }
            
            return response()->json([
                'message' => 'success',
                'user' => $getUser
            ], JsonResponse::HTTP_OK);
            
        } else {
            return response()->json(['errors' => 'error sever'], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

    }

    //Handle update profile for user
    public function update (UpdateProfileRequest $request, int $id) 
    {
        $user = User::findOrFail($id); //Lấy user trong csdl theo id từ request         
        $dataRequest = $request->all(); //Lấy data request mà client gửi lên 

       






    }

}


