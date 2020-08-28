<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductType;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function index1()
    {
        $data = User::all()->toArray();
        return view('admin/list',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getProfile()
    {     
       return view('admin/profile');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postProfile(Request $request)
    {
        $id = Auth::user()->id;
        $admin = User::findOrFail($id);
        $update_profile = $request->all();
        if (empty($update_profile['password'])) {
            $update_profile['password'] = $admin['password'];
        }else{
             $update_profile['password'] = bcrypt($update_profile['password']);
        }
        if ($admin->update($update_profile)) {
            
            return redirect()->back()->with('success', __('Update profile success.'));
        } else {
            return redirect()->back()->withErrors('Update profile error.');
        }
    }

    //--------New product---------------------------------
    public function getNews()
    {     
       $new = Product::where('new',1)->paginate(5); 
       return view('admin/new/new_product',compact('new'));
    }
    public function getAdd()
    {
        $ProductType = ProductType::all()->toArray();
        return view('admin/new/add',compact('ProductType'));
    }
    public function postAdd(Request $request)
    {
        $data_add = $request->all();
        $data_add['new'] = 1;
        if ($request->hasFile('image')) {
            $file = $request->image;
            $data_add['image'] = $file->getClientOriginalName();
        }
        if (Product::create($data_add)) {
            if ($request->hasFile('image')) {
                $file->move('source/image/product',$file->getClientOriginalName());
            }
            return redirect()->back()->with('success', __('Create Product success.'));
        } else {
            return redirect()->back()->withErrors('Create Product error.');
        }
    }

    public function getEdit($id)
    {
        $type_product = ProductType::all()->toArray();
        $data = Product::find($id)->toArray();
        return view('admin/new/edit',compact('data','type_product'));
    }
    public function postEdit(Request $request, $id)
    {
        $data_edit = Product::findOrFail($id);
        $update = $request->all();
        if ($request->hasFile('image')) {
            $file = $request->image;
            $update['image'] = $file->getClientOriginalName();
        }else{
            $update['image'] = $data_edit['image'];
        }
        if ($data_edit->update($update)) {
            if ($request->hasFile('image')) {
                $file->move('source/image/product',$file->getClientOriginalName());
            }
            return redirect()->back()->with('success', __('Update Product success id ='. $id));
        } else {
            return redirect()->back()->withErrors('Update Product error.');
        }
    }
    public function getDelete($id)
    {
        $delete = Product::find($id)->delete();
         if($delete){
            return redirect()->back()->with('success', __('Update Product success id ='. $id));
        } else {
            return redirect()->back()->withErrors('Update Product error.');
        }
    }    
    
    //--------------------------------------------------------------


    //--------Old product -------------------------------------------
    public function getOld()
    {
        $old = Product::where('new',0)->paginate(5);
        return view('admin/old/old_product',compact('old'));
    }
    public function getOldAdd()
    {
        $ProductType = ProductType::all()->toArray();
        return view('admin/old/add',compact('ProductType'));
    }
    public function postOldAdd(Request $request)
    {
        $dataOld_add = $request->all();
        $dataOld_add['new'] = 0;

        if ($request->hasFile('image')) {
            $file = $request->image;
            $dataOld_add['image'] = $file->getClientOriginalName();
        }
        if (Product::create($dataOld_add)) {
            if ($request->hasFile('image')) {
                $file->move('source/image/product',$file->getClientOriginalName());
            }
            return redirect()->back()->with('success', __('Create Product success.'));
        } else {
            return redirect()->back()->withErrors('Create Product error.');
        }
    }
    public function getOldEdit($id)
    {
        $data_edit = Product::find($id)->toArray();
        $type_product = ProductType::all()->toArray();
        return view('admin/old/edit',compact('type_product','data_edit'));
    }
    public function postOldEdit(Request $request, $id)
    {
        $data = Product::findOrFail($id);
        $update = $request->all();
        if ($request->hasFile('image')) {
            $file = $request->image;
            $update['image'] = $file->getClientOriginalName();
        }else{
            $update['image'] = $data_edit['image'];
        }
        if ($data->update($update)) {
            if ($request->hasFile('image')) {
                $file->move('source/image/product',$file->getClientOriginalName());
            }
            return redirect()->back()->with('success', __('Update Product success id ='. $id));
        } else {
            return redirect()->back()->withErrors('Update Product error.');
        }
    }
    public function Delete($id)
    {
        $delete = Product::find($id)->delete();
         if($delete){
            return redirect()->back()->with('success', __('Update Product success id ='. $id));
        } else {
            return redirect()->back()->withErrors('Update Product error.');
        }
    }
    //------------Product type-------------------------------------------------------------
    public function getType()
    {
        $type = ProductType::all()->toArray();
        return view('admin/TypeProduct/list',compact('type'));
    }
    public function getTypeAdd()
    {
        return view('admin/TypeProduct/add');
    }
    public function getTypePost(Request $request)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $file = $request->image;
            $data['image'] = $file->getClientOriginalName();
        }
         if (ProductType::create($data)) {
            if ($request->hasFile('image')) {
                $file->move('source/type',$file->getClientOriginalName());
            }
            return redirect()->back()->with('success', __('Create TypeProduct success.'));
        } else {
            return redirect()->back()->withErrors('Create TypeProduct error.');
        }
    }
    public function getTypeEdit($id)
    {
        $data_type = ProductType::find($id)->toArray();
        return view('admin/TypeProduct/edit',compact('data_type'));
    }
    public function TypePost(Request $request, $id)
    {
        $type = ProductType::findOrFail($id);
        $update = $request->all();
        if ($request->hasFile('image')) {
            $file = $request->image;
            $update['image'] = $file->getClientOriginalName();
        }else{
            $update['image'] = $type['image'];
        }
         if ($type->update($update)) {
            if ($request->hasFile('image')) {
                $file->move('source/type',$file->getClientOriginalName());
            }
            return redirect()->back()->with('success', __('Update TypeProduct success id ='. $id));
        } else {
            return redirect()->back()->withErrors('Update TypeProduct error.');
        }
    }
    public function getTypeDelete($id)
    {
        $delete = ProductType::find($id)->delete();
         if($delete){
            return redirect()->back()->with('success', __('Update Product success id ='. $id));
        } else {
            return redirect()->back()->withErrors('Update Product error.');
        }
    }
}
