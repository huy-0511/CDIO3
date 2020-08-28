@extends('admin.master.master')
@section('content')

        <aside class="left-sidebar" data-sidebarbg="skin5">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('admin/dashboard')}}" aria-expanded="false">
                                <i class="mdi mdi-av-timer"></i>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                         <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ url('admin/list')}}" aria-expanded="false">
                                <i class="mdi mdi-av-timer"></i>
                                <span class="hide-menu">List-user</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('admin/profile')}}" aria-expanded="false">
                                <i class="mdi mdi-account-network"></i>
                                <span class="hide-menu">Profile</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ url('admin/product_new')}}" aria-expanded="false">
                                <i class="mdi mdi-account-network"></i>
                                <span class="hide-menu">new_product</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-5 align-self-center">
                        <h4 class="page-title">Update Product</h4>
                    </div>
                    <div class="col-7 align-self-center">
                        <div class="d-flex align-items-center justify-content-end">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Update Product</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
                <div class="row">

                    <div class="col-lg-8 col-xlg-9 col-md-7">
                         @if(session('success'))
                                    <div class="alert alert-success alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <h4><i class="icon fa fa-check"></i> Thông báo!</h4>
                                        {{session('success')}}
                                    </div>
                        @endif
                        <div class="card">
                            <div class="card-body">
                                @if ($errors->any())
                                  <div class="alert alert-danger">
                                      <ul>
                                        @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                      </ul>
                                  </div>
                                @endif

                                <form action="" method="post" class="form-horizontal form-material" enctype="multipart/form-data">
                                    @csrf
                                 
                                    <div class="form-group">
                                        <label class="col-md-12">Name</label>
                                        <div class="col-md-12">
                                            
                                            <input type="text" name="name" value="<?php echo $data_edit['name']; ?>" class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="example-email" class="col-md-12">Unit_price</label>
                                        <div class="col-md-12">
                                           <input name="unit_price" value="<?php echo $data_edit['unit_price']; ?>" class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">promotion_price</label>
                                        <div class="col-md-12">
                                            <input name="promotion_price" value="<?php echo $data_edit['promotion_price']; ?>" class="form-control form-control-line">
                                        </div>
                                    </div>
                                     
                                    <div class="form-group">
                                        <label class="col-md-12">Image</label>
                                        <div class="col-md-12">
                                            <input type="file" name="image">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Description</label>
                                        <input type="text" class="form-control" value="<?php echo $data_edit['description']; ?>" name="des">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Unit</label>
                                        <div class="col-md-12">
                                             
                                            <input type="text" name="unit" value="<?php echo $data_edit['unit']; ?>" class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-12">Select Type</label>
                                        <div class="col-sm-12">

                                            <select name="id_type" class="form-control form-control-line">
                                                <option value="">Please select</option>
                                            @foreach($type_product ?? '' as $key => $type)
                                                <option 
                                               <?=
                                                 $type['id'] == $data_edit['id_type'] ? "selected" : ' ' ;
                                                 ?> 
                                                value="{{$type['id']}}">{{$type['name']}}</option>
                                             @endforeach   
                                                
                                                
                                               
                                            </select>
                                      
                                           <!--  -->
                                        </div>
                                    </div>
                             
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <!-- <input type="submit" name="update" value="Update Profile" class="btn btn-success"> -->
                                            <button type="submit" class="btn btn-success">Update</button>
                                            <a href="{{url('admin/product_old')}}"class="btn btn-success">Back</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>

                <!-- Row -->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center">
                All Rights Reserved by Nice admin. Designed and Developed by
                <a href="https://wrappixel.com">WrapPixel</a>.
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
@endsection
