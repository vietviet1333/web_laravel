@extends('Admin.layout_admin')
@section('title')
    User Management
@endsection
@section('body')
    <nav class="navbar navbar-light bg-light">
        <div class="container-fluid">

            <input class="form-control me-2" type="text" placeholder="Search" aria-label="Search" id="search" name="search">
            
            @csrf

        </div>
    </nav>
    @if (count($users) > 0)
        @php
            $i = 1
        @endphp
        <div class="row">
            <div class="col-md-12">
                <div class="card card-plain">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title mt-0">User Management</h4>
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
                                           Name
                                        </th>
                                        <th>
                                            Address
                                        </th>
                                        <th>
                                            Email
                                        </th>
                                        <th>
                                            Phone
                                        </th>
                                    </tr>
                                </thead>
                                
                                <tbody  >

                                    @foreach ($users as $item)
                                        <tr>
                                            <td>
                                                {{$i++}}
                                            </td>
                                            <td>
                                                {{ $item->name }}
                                            </td>
                                            <td>
                                                {{ $item->address }}
                                            </td>
                                            <td>
                                                {{ $item->email }}
                                            </td>
                                            <td>
                                                {{ $item->phone }}
                                            </td>
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
@endsection
@section('scripts')
<script src="https://ajax.aspnetcdn.com/ajax/jquery/jquery-1.9.0.js"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#search').keyup(function() {
                $value = $(this).val();
                $.ajax({
                    type: 'GET',
                    url: '{{ URL::to('/admin/search/user') }}',
                    data: {
                        'search': $value,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        $('tbody').html(data);
                        console.log(data)
                    }
                });
            })
        })
    </script>
@endsection
