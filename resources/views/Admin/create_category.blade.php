@extends('Admin.layout_admin')
@section('title')
    Insert Snacks
@endsection
@section('body')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Add Category </h4>
                    <p class="card-category">Complete your category </p>
                </div>
                <div class="card-body">
                    @if (session()->has('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session()->get('success') }}
                                </div>
                            @endif
                    <form action="/admin/add-category" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    Name Category
                                    <input type="text" name="inputCategory" class="form-control">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success">Insert</button>
                        <div class="clearfix"></div>
                    </form>
                </div>


            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection
