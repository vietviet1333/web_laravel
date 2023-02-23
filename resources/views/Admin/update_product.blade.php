@extends('Admin.layout_admin')
@section('title')
    Update Snacks
@endsection
@section('body')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Update Snacks</h4>
                    <p class="card-category">Complete your snacks</p>
                </div>
                <div class="card-body">
                   
                        @csrf
                        @foreach ($products as $product)
                        <form action="/admin/update-product" method="get" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" value="{{ $product->id_product }}" hidden name="inputID">
                                <div class="form-group">
                                    Name
                                    <input type="text" name="inputName" class="form-control" value="{{ $product->name_product }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                Image
                                <input type="file" name="image" class="form-control">
                                <img src="{{ asset('uploads/'.$product->image_product) }}" width="100px" height="100px">
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    Ingredient
                                    <textarea class="ckeditor form-control" name="inputIngredient" id="inputIngredient">{{ $product->ingredient }}</textarea>
                                </div>
                            </div>
                        </div>

                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    ID Category
                                    <input type="text" name="inputIDCategory" class="form-control" value="{{ $product->id_category }}">
                                </div>
                            </div>
                        </div>

                        
                      
                    
                        <button type="submit" class="btn btn-success">Update</button>
                        <div class="clearfix"></div>
                    </form>
                    @endforeach
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
            filebrowserBrowseUrl: "{{ route('ckfinder_browser') }}"
        });
    </script>
    @include('ckfinder::setup')
@endsection
