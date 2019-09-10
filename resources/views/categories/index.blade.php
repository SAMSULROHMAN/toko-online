@extends('layouts.global')
@section('title')
    Categories
@endsection

@section('content')
@if(session('status'))
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning">
                {{session('status')}}
            </div>
        </div>
    </div>
@endif
    <div class="row">
        <div class="col-md-6">
            <form action="{{route('categories.index')}}">
                <div class="input-group">
                    <input
                    type="text"
                    class="form-control"
                    placeholder="Filter by category name"
                    value="{{ Request::get('keyword')}}"
                    name="keyword">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">
                            <span class="oi oi-magnifying-glass"></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <ul class="nav nav-pills card-header-pills">
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('categories.index')}}">Published</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('categories.trash')}}">Trash</a>
                </li>
            </ul>
        </div>
    </div>

    <hr class="my-3">

    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered table-stripped">
                <thead>
                    <tr>
                        <th><b>Name</b></th>
                        <th><b>Slug</b></th>
                        <th><b>Image</b></th>
                        <th><b>Actions</b></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                    <tr>
                        <td>{{$category->name}}</td>
                        <td>{{$category->slug}}</td>
                        <td>
                        @if($category->image)
                            <img
                            src="{{asset('storage/' . $category->image)}}"
                            width="48px"/>
                        @else
                            No image
                        @endif
                        </td>
                        <td>
                            <a href="{{route('categories.show', $category->id)}}" class="btn btn-primary btn-sm">Show</a>
                            <a href="{{ route('categories.edit',$category->id)}}" class="btn btn-info btn-sm">Edit</a>
                            <form class="d-inline" action="{{route('categories.destroy',$category->id)}}" method="POST" onsubmit="return confirm('Move category to trash?')">
                                @csrf
                                @method('DELETE')
                                <input type="submit" class="btn btn-danger btn-sm" value="Trash">
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colSpan="10">
                            {{$categories->appends(Request::all())->links()}}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
