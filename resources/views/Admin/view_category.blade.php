@extends('Admin.layout_admin')
@section('title')
    View Category
@endsection
@section('body')
@if (count($category) > 0)
@php
    $i = 1
@endphp
<div class="row">
    <div class="col-md-12">
        <div class="card card-plain">
          <div class="card-header card-header-primary">
            <h4 class="card-title mt-0">Category List</h4>
            <p class="card-category">All data from the category</p>
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
                            Name Category
                          </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ( $category as $cate )
                    <tr>
                        <td>
                            {{$i++}}
                        </td>
                        <td>
                            {{$cate->name_category}}
                        </td>
                        <td>
                            <a href="/admin/edit-category/{{$cate->id_category}}" class="btn btn-success">Edit</a>
                        </td>
                        <td>
                            <a href="/admin/delete-category/{{$cate->id_category}}" class="btn btn-danger">Delete</a>
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
@endsection
