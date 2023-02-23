@extends('Client.Layout')
@section('body')

<div class="container">
    <div class="row justity-content-center">
        @if (count($order) > 0)
@php
    $i=1
@endphp
<div class="row">
    <div class="col-md-12">
        <div class="card card-plain">
          <div class="card-header card-header-primary">
            <h4 class="card-title mt-0">Purchase History</h4>
            <p class="card-category">All data from Purchase History</p>
            @if (Session::get('notification'))
                <h3 class="text-success">@php echo Session::get('notification');
                    Session::put('notification',null);
                    @endphp</h3>
            @endif
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead class="">
                    <tr>
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
                            <a href="/category/buy/{{$orde->id_product}}">Link to purchased product</a>
                        </td>
                        @else
                        <td class="text-center">
                            <span >Waiting for payment confirmation...</span>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
@else
<h1>No result</h1>
@endif
    </div>
</div>
@endsection

@section('scripts')
@endsection
