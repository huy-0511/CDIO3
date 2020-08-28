<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\Slide;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Bill;
use App\Models\BillDetails;
use App\Models\User;
use App\Http\Requests\SigninRequest;
use App\Http\Requests\LoginRequest;
use Session;
use Hash;
use Auth;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function getIndex(){
    	$slide = Slide::all();
    	$new_product =Product::where('new',1)->paginate(4);
        $sanpham_khuyenmai = Product::where('promotion_price','<>',0)->paginate(8); 
    	return view('page/trangchu',compact('slide','new_product','sanpham_khuyenmai'));
    }
    public function getLoaiSp($type){
        $loaisp = Product::where('id_type',$type)->get();
        $sp_khac = Product::where('id_type','<>',$type)->paginate(3);
        $loai = ProductType::all(); 
        $loai_sp = ProductType::where('id',$type)->first();// 1 loai san pham chi co mot id
    	return view('page/loaisanpham',compact('loaisp','sp_khac','loai','loai_sp'));
    }
    public function getChitiet($id){
        $sanpham = Product::where('id',$id)->first();// moi san pham co 1 id duy nhat
        $sanpham_tuongtu = Product::where('id_type',$sanpham->id_type)->paginate(6);
    	return view('page/chitietsanpham',compact('sanpham','sanpham_tuongtu'));
    }
    public function getLienhe(){
    	return view('page/lienhe');
    }
    public function getAddtoCart(Request $request,$id){

        $product = Product::find($id);
        $oldCart = Session('cart')?Session::get('cart'):null; //nếu có thì lấy giỏ hàng ra
        $cart = new Cart($oldCart);
        $cart->add($product,$id);
        $request->session()->put('cart',$cart);// đưa giỏ hàng vào session cart put(dung để thêm vào)
        return redirect()->back();
    }
    public function getDelete($id_delete){
        $oldCart = Session::has('cart')?Session::get('cart'):null;//nếu có hang thì dùng sesion lấy cart bỏ vao
        $cart = new Cart($oldCart);
        $cart->reduceByOne($id_delete);
        
        if (count($cart->items)>0) {
            Session::put('cart',$cart); 
        }else{
            Session::forget('cart');
        }
        // dd($cart);
        return redirect()->back(); 
    }
    public function getCheckout(){
        return view('page/dathang');
    }
    public function postCheckout(Request $req){
        $cart = Session::get('cart');
        // dd($cart);
        $customer = new Customer;
        $customer->name = $req->name;
        $customer->gender = $req->gender;
        $customer->email = $req->email;
        $customer->address = $req->address;
        $customer->phone_number = $req->phone;
        $customer->note = $req->notes;
        $customer->save();

        $bill = new Bill;
        $bill->id_customer = $customer->id;
        $bill->date_order = date('Y-m-d');
        $bill->total = $cart->totalPrice;
        $bill->payment = $req->payment_method;
        $bill->note = $req->notes;
        $bill->save();

        foreach ($cart->items as $key => $value) {  
            // dd($value);
            $bill_detail = new BillDetails;
            $bill_detail->id_bill = $bill->id;
            $bill_detail->id_product = $key;
            $bill_detail->quantity = $value['qty'];
            $bill_detail->unit_price = ($value['price']/$value['qty']);
            $bill_detail->save();

        }
        Session::forget('cart');
        return redirect()->back()->with('thongbao','Đặt hàng thành công');

    }

     public function getSignin(){
        return view('page/dangki');
    }
    public function postSignin(SigninRequest $req){
        $user = new User();
        $user->full_name = $req->fullname;
        $user->email = $req->email;
        $user->password = Hash::make($req->password); // mã hóa mật khẩu
        $user->phone = $req->phone;
        $user->address = $req->address;
        $user->level = 0;
        $user->save();
        return redirect()->back()->with('thanhcong','Tạo tài khoản thành công');
    }
    public function getLogin(){
        return view('page/dangnhap');
    }
    public function postLogin(LoginRequest $req){
        $login = array(
            'email'=>$req->email,
            'password'=>$req->password,
            'level' => 0
        );
        // $user = User::where([
        //         ['email','=',$req->email],
        //         ['status','=','1']
        //     ])->first();

        // if($user){
            if(Auth::attempt($login)){

            return redirect('index')->with(['flag'=>'success','message'=>'Đăng nhập thành công']);
            }
            else{
                return redirect()->back()->with(['flag'=>'danger','message'=>'Đăng nhập không thành công']);
            }
        // }
        // else{
        //    return redirect()->back()->with(['flag'=>'danger','message'=>'Tài khoản chưa kích hoạt']); 
        // }
        
    }
    public function postLogout(){
        Auth::logout();
        return redirect()->route('login_member');
    }
    public function getSearch(Request $req){
        $product = Product::where('name','like','%'.$req->key.'%')// % nối chuỗi
                           ->orWhere('unit_price',$req->key)
                           ->get();      
        return view('page/search',compact('product'));
    }
}
