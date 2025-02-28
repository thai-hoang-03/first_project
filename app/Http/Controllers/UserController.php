<?php
namespace App\Http\Controllers;
use App\Models\CustomUser;
use Illuminate\Routing\Controller;

class UserController extends Controller {
    public function index(){
        return "oke";
    }

    public function show(int $id) {
        return "User có id là {$id}";
    }

    public function getProducts(){
        return response()->json([
            ['id' => 1, 'name' => 'iPhone 13', 'price' => 2000],
            ['id' => 2, 'name' => 'Samsung Galaxy S22', 'price' => 1800],
            ['id' => 3, 'name' => 'Google Pixel 6', 'price' => 1500],
        ]);
    }
}

?>