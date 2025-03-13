<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Http\Requests\api\ProductRequest;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth ;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{

    //Create product 
    public function store(ProductRequest $request ) 
    {
        $dataRequest = $request->all();

        if($request->hasFile('image')){
            $ImageUpload = $this->uploadImageToDirectory($request->file('image'));
            $dataRequest['image'] = json_encode($ImageUpload);
        }

        $dataRequest['id_category'] = $dataRequest['category'];
        $dataRequest['id_brand'] = $dataRequest['brand'];
        $dataRequest['company_profile'] = $dataRequest['company'];
        $dataRequest['id_user'] = Auth::id();

        $newProduct = Product::create($dataRequest);
        if($newProduct){
            return response()->json([
                'response' => 'sucsess',
                'product' => $newProduct
            ], JsonResponse::HTTP_OK);
        }
    }

    public function uploadImageToDirectory($arrImage)
    {
        $imageUpload = [];
        foreach($arrImage as $image){
            $userId =Auth::id(); //lấy userID hiện tại ra
            $uploadPath = 'upload/product'.$userId;
            $nameImg = strtotime(date('Y-m-d H:i:s')).'_'.$image->getClientOriginalName();
            
            //kiểm tra xem coi đã có file trong thư mục hay project hay chưa 
            if(!file_exists(public_path($uploadPath))){
                mkdir($uploadPath);
            }

            //Lưu file ảnh vào public
            $image->move(public_path($uploadPath), $nameImg);
            $imageUpload[] = $uploadPath . '/' . $nameImg;
        }
        return $imageUpload;
    }

}
