@foreach ($products as $item )
<div data-aos="zoom-in" class="col-12 col-sm-6 col-md-4 p-2 border border-light">
           
    <img src="{{ asset('uploads/') }}/{{ $item->image_product }}" class="card-img-top"
        style="max-height: 20rem"alt="..." >
     
    <div class="card-body">
        <h5 class="card-title">{{ $item->name_product }}</h5>
        <h5 class="card-title" style="font-size: 0.7rem;color:red">{{ $item->price }}đ</h5>
        <a href="/show/{{ $item->id_product }}" class="btn btn-primary" style="background-color: black">Xem chi tiết</a>
       
    </div>

</div>
  

   
@endforeach
