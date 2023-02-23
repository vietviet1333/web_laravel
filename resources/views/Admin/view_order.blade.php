@extends('Admin.layout_admin')
@section('title')
    Order Of Customer
@endsection
@section('body')
<nav class="navbar navbar-light bg-light">
    <div class="container-fluid">
      <form class="d-flex">
        <input class="form-control me-2" type="search" id="search" placeholder="Search" aria-label="Search" name="search">
        {{-- <button class="btn btn-outline-success" type="submit">Search</button> --}}
      </form>
    </div>
  </nav>
@if (count($order) > 0)
@php
    $i = 1
@endphp

<div class="row">
    <div class="col-md-12">
<form action="/admin/order/access" method="post">
@csrf
        <div class="card card-plain">
          <div class="card-header card-header-primary">
            <h4 class="card-title mt-0">Order Of Custormer</h4>
            <p class="card-category">All data from the order</p>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead class="">
                    <tr>
                        <th>
                            <input type="checkbox" name="select-all" id="select-all" />
                        </th>
                        <th>
                            No.
                          </th>
                          <th>
                            Name Customer
                          </th>
                          <th>
                            Name product
                          </th>
                          <th>
                            Price
                          </th>
                          <th class="text-center">
                            Status
                          </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ( $order as $orde)
                    <tr>
                        <td><input type="checkbox" name="ids[{{$orde->id_order}}]" value="{{$orde->id_order}}" class="checkbox"></td>
                        <td>
                            {{$i++}}
                        </td>
                        <td>
                            {{$orde->name}}
                        </td>
                        <td>
                            {{$orde->name_product}}
                        </td>
                        <td>
                            {{$orde->price}}
                        </td>
                        @if ($orde->payment)
                        <td class="text-center">
                            <a href="/admin/no-accept/{{$orde->id_order}}" class="btn btn-danger">No Accept</a>
                        </td>
                        @else
                        <td class="text-center">
                            <a href="/admin/accept/{{$orde->id_order}}" class="btn btn-success">Accept</a>
                        </td>
                        @endif


                    </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
            <button type="submit" class="btn btn-success" value="ACCEPT" >ACCEPT</button>

          </div>
        </div>
    </form>

        {!! $order->links() !!}
      </div>
    </div>
@else
<h1>No result</h1>
@endif
@endsection
@section('scripts')

@endsection
<script src="https://ajax.aspnetcdn.com/ajax/jquery/jquery-1.9.0.js"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script>
        $(document).ready(function() {

       $('#select-all').click(function(event) {
       if(this.checked) {

           $('.checkbox').each(function() {
               this.checked = true;
           });
       } else {
           $('.checkbox').each(function() {
               this.checked = false;
           });
       }
   })
        });
   </script>

    <script>
        $(document).ready(function() {
            $('#search').keyup(function() {
                $value = $(this).val();
                $.ajax({
                    type: 'get',
                    url: '{{ URL::to('admin/order/search') }}',
                    data: {
                        'search': $value,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        $('tbody').html(data);
                    }
                });
            })
        })
    </script>

