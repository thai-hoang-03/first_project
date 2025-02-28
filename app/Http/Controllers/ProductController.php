<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\api\ProductRequest;
use Illuminate\Routing\Controller;

class ProductController extends Controller
{
    //lấy tất cả sản phẩm
    public function getAll()
    {
        $getData = Product::all();


        return response()->json(['data' => $getData]);
    }

    //Lấy sản phẩm theo ID
    public function getFollowId($id)
    {
        return response()->json(Product::findOrFail($id));
    }

    //Thêm sản phẩm mới
    public function addItem(ProductRequest $request)
    {
        $product = Product::create($request->all());
        return response()->json($product, 201);
    }

    //Cập nhật sản phẩm
    public function updateItem(ProductRequest $request, $id)
    {
        // echo $id;

        $product = Product::findOrFail($id);

        $getData = $request->all();

        // var_dump($getData);
        // exit;

        if ($product->update($getData)) {
            return response()->json($product);
        } else {
            return response()->json(["error" => "loi update, vui long kiem tra lai"]);
        }
        // 
    }

    //Xoá sản phẩm
    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(['mess' => 'Finish']);
    }
}
