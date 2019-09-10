@extends('layouts.global')

@section('title')
    Data User
@endsection

@section('content')
    @if(session('status'))
        <div class="alert alert-success">
            {{session('status')}}
        </div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('users.index')}}">
                <div class="input-group mb-3">
                    <input type="text" value="{{ Request::get('keyword' )}}" name="keyword" class="form-control col-md-10" placeholder="Filter berdasarkan Email">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">
                            <span class="oi oi-magnifying-glass"></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <form action="{{ route('users.index')}}">
                    <input {{Request::get('status') == 'ACTIVE' ? 'checked' : ''}}
                    value="ACTIVE"
                    name="status"
                    type="radio"
                    class="form-control"
                    id="active">

                    <label for="active">Active</label>
                    <input {{Request::get('status') == 'INACTIVE' ? 'checked' : ''}}
                    value="INACTIVE"
                    name="status"
                    type="radio"
                    class="form-control"
                    id="inactive">
                    <label for="inactive">Inactive</label>

                    <button type="submit" class="btn btn-primary">
                        <span class="oi oi-magnifying-glass"></span>
                    </button>
            </form>
        </div>
    </div>

    <hr class="my-3">

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-12 text-right">
                    <a href="{{route('users.create')}}" class="btn btn-primary text-right">Create user</a>
                </div>
            </div>
        </div>
        <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th><b>Name</b></th>
                            <th><b>Username</b></th>
                            <th><b>Email</b></th>
                            <th><b>Avatar</b></th>
                            <th><b>Status</b></th>
                            <th><b>Action</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{$user->name}}</td>
                                <td>{{$user->username}}</td>
                                <td>{{$user->email}}</td>
                                <td>
                                    @if($user->avatar)
                                        <img src="{{asset('storage/'.$user->avatar)}}" width="70px"/>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if($user->status == "ACTIVE")
                                    <span class="badge badge-success">
                                    {{$user->status}}
                                    </span>
                                    @else
                                    <span class="badge badge-danger">
                                    {{$user->status}}
                                    </span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('users.show',$user->id)}}" class="btn btn-primary btn-sm ">Detail</a>
                                    <a class="btn btn-info text-white btn-sm" href="{{route('users.edit', $user->id)}}">Edit</a>
                                    <form onsubmit="return confirm('Delete this user permanently?')" class="d-inline" action="{{route('users.destroy',$user->id)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" value="Delete" class="btn btn-danger btn-sm">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="10" class=" text-right">
                                {{ $users->appends(Request::all())->links() }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
        </div>
    </div>
@endsection
