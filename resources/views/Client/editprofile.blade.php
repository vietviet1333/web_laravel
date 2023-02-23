@extends('Client.Layout')
@section('body')
    <div class="container" >
        <form accept-charset='UTF-8' action='/save' id='create_customer' method='get'>
            <div>
                @foreach ($edits as $e)
                    <label class="col-sm-2 col-form-label" >Name:</label>
                    <div class="col-sm-5">
                        <input type="text" name="name" id="name" class="form-control"value="{{ $e->name }}">
                    </div>

                    <label class="col-sm-2 col-form-label">Address:</label>
                    <div class="col-sm-5">
                        <input type="text" name="address" class="form-control"value="{{ $e->address }}">
                    </div>

                    <label class="col-sm-2 col-form-label">Password:</label>
                    <div class="col-sm-5">
                        <input type="text" name="password" class="form-control">
                    </div>

                    <label class="col-sm-2 col-form-label">Phone:</label>
                    <div class="col-sm-5">
                        <input type="text" name="phone" class="form-control"value="{{ $e->phone }}">
                    </div>
                    <td><button  class="editUser btn btn-danger mt-3 mb-5 text-center" type="submit"
                            style="min-width:90px;padding: 5px 10px;">Save changes</button></td>
                @endforeach
                @csrf
            </div>
        </form>
    </div>
@endsection
