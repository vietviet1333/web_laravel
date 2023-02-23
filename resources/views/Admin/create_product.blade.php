@extends('Admin.layout_admin')
@section('title')
    Insert Snacks
@endsection
@section('body')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Add Product</h4>
                    <p class="card-category">Complete your product</p>
                </div>
                <div class="card-body">
                    @if (session()->has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session()->get('success') }}
                    </div>
                @endif
                    <form action="/admin/add-product" method="POST" enctype="multipart/form-data" >
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    Name
                                    <input type="text" name="inputName" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                Image
                                <input type="file" name="image" class="form-control">
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    Information
                                    <textarea class="ckeditor form-control" name="inputIngredient" id="inputIngredient"></textarea>
                                </div>
                            </div>
                        </div>

                       

                       
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    ID Category
                                    <br>
                                    @if (count($category)>0)
                                        @foreach ($category as $cate)
                                            {{$cate->id_category}} -> {{$cate->name_category}}
                                            <br>
                                        @endforeach
                                    @endif
                                    <input type="text" name="inputIDCategory" class="form-control">
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    Price
                                    <input type="number" name="inputPrice" class="form-control">
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
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/ckfinder/ckfinder.js') }}"></script>
    <script>
        CKEDITOR.replace('inputIntroduce', {
            filebrowserBrowseUrl     : "{{ route('ckfinder_browser') }}"
        });
    </script>
   
    @include('ckfinder::setup')
@endsection
