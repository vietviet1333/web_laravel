@extends('Admin.layout_admin')
@section('title')
Admin Dashboard
@endsection
@section('body')
<div class="row">
    <div class="col-sm-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">User Management</h5>
          <a href="/admin/user-management" class="btn btn-danger">Here</a>
        </div>
      </div>
    </div>
    
    <div class="col-sm-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Order Management</h5>
          <a href="/admin/order" class="btn btn-danger">Here</a>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Category Management</h5>
            <a href="/admin/category" class="btn btn-danger">Here</a>
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Product Management</h5>
            <a href="/admin/product" class="btn btn-danger">Here</a>
          </div>
        </div>
      </div>
  </div>
@endsection