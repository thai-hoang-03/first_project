<?php

namespace App\Http\Controllers;

use App\Http\Requests\api\LoginRequest;
use App\Http\Requests\api\UpdateProfileRequest;
use App\Http\Requests\api\UserRequest;
use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image as Image;

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
        if ($request->remember_me) {
            $remember = true;
        };

        if (Auth::attempt($dataLogin, $remember)) {
            $user = Auth::user();
            // Log::info('User sau khi đăng nhập:', [$user]); 

            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json(
                [
                    'success' => 'success',
                    'token' => $token,
                    'Auth' => $user
                ],
                $this->successStatus
            );
        } else {
            return response()->json(
                [
                    'response' => 'error',
                    'errors' => ['errors' => 'invalid email or password'],
                ],
                $this->successStatus
            );
        }
    }

    //Handle register for user
    public function register(UserRequest $request)
    {
        $data = $request->all();
        
        $data['password'] = bcrypt($data['password']);  //Xử lý password

        $avatar = $request->hasFile('avatar');    //Kiểm tra xem trong request gửi lên có file avatar hay không
        if ($avatar) {
            $image = $request->file('avatar'); //Lấy file avatar
            $data['avatar'] = $image->getClientOriginalName();
        }

        if ($getUser = User::create($data)) {
            if ($avatar) {
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
    public function update(UpdateProfileRequest $request, int $id)
    {

        $user = User::findOrFail($id); //   Lấy user modal theo userID hiện tại gửi requestrequest


        //Kiểm tra email đã tồn tại hay chưa ngoại trừ userID hiện tại
        $getUserEmail = User::where('email', $request->email)  // Lấy user model theo email request nhưng khác id của client gửi lên
            ->where('id', '<>', $id)
            ->first();

        //Kiểm tra nếu có tồn tại thì báo lỗi do bị trùng email với một user khác và dừng tiến trình updateupdate
        if ($getUserEmail) {
            return response()->json([
                'error' => ['email' => 'email đã tồn tại !'],
                'email' => $getUserEmail->email
            ], JsonResponse::HTTP_CONFLICT);
        }

        //Tạo mảng chứa dữ liệu những trường thay đổi và chỉ update các trường trong data nếu có thay đổi
        $dataUpdate = [];
        $fields = ['name', 'email', 'phone', 'address'];

        foreach ($fields as $field) {
            //chỉ update nếu các value của các key trong request khác với dữ liệu cũ
            if ($request->has($field) && $user->$field !== $request->$field) {
                $dataUpdate[$field] = $request->$field;
            }
        }

        //Xử lý password kiểm tra xem pass request không rỗng và pass mới có giống với pass cũ hay không
        if (!empty($request->password) && !Hash::check($request->password, $user->password)) {
            $dataUpdate['password'] = bcrypt($request->password);
        }

        // Xử lý avatar
        if ($request->hasFile('avatar')) { // Nếu là file upload
            $file = $request->file('avatar');
            $avatarName = time() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('upload/user/avatar'), $avatarName); // Lưu file vào thư mục

            $dataUpdate['avatar'] = $avatarName;
        } elseif (!empty($request->avatar) && strpos($request->avatar, ';') !== false) { // Nếu là base64
            $name = time() . '.png';

            Image::make($request->avatar)->save(public_path('upload/user/avatar/' . $name)); // Lưu base64 thành file

            $dataUpdate['avatar'] = $name;
        }


        //Nếu có dữ liệu trong biến $dataUpdate thì thực hiện update 
        if (!empty($dataUpdate)) {
            if ($user->update($dataUpdate)) {
                $token = !empty($dataUpdate['password']) ? $user->createToken('authToken')->plainTextToken : null;
                return response()->json([
                    'response' => 'update profile success',
                    'token' => $token,
                    'Auth' => $user->refresh() // response thông tin user mới nhất
                ], JsonResponse::HTTP_OK);
            } else {
                return response()->json([
                    'errors' => 'errors update'
                ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

        return response()->json([
            'message' => 'không có thay đổi nào cần cập nhật'
        ], JsonResponse::HTTP_OK);
    }

    
}
