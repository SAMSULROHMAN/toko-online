@extends('layouts.global')
@section('title')
    Edit Order
@endsection
@section('content')
    <div class="row">
        <div class="col-md-8">
            @if(session('status'))
                <div class="alert alert-success">
                    {{session('status')}}
                </div>
            @endif
            <form class="shadow-sm bg-white p-3" action="{{route('orders.update', $orders->id)}}" method="POST">
                @csrf
                @method('PUT')
                <label for="invoice_number">Invoice number</label><br>
                <input type="text" class="form-control" value="{{$orders-
                >invoice_number}}" disabled>
                <br>
                <label for="">Buyer</label><br>
                <input disabled class="form-control" type="text" value="{{$orders->user-
                >name}}">
                <br>
                <label for="created_at">Order date</label><br>
                <input type="text" class="form-control" value="{{$orders->created_at}}"
                disabled >
                <br>
                <label for="">Books ({{$orders->totalQuantity}}) </label><br>
                <ul>
                @foreach($orders->books as $book)
                <li>{{$book->title}} <b>({{$book->pivot->quantity}})</b></li>
                @endforeach
                </ul>
                <label for="">Total price</label><br>
                <input class="form-control" type="text" value="{{$orders->total_price}}"
                disabled>
                <br>
                <label for="status">Status</label><br>
                <select class="form-control" name="status" id="status">
                <option {{$orders->status == "SUBMIT" ? "selected" : ""}}
                value="SUBMIT">SUBMIT</option>
                <option {{$orders->status == "PROCESS" ? "selected" : ""}}
                value="PROCESS">PROCESS</option>
                <option {{$orders->status == "FINISH" ? "selected" : ""}}
                value="FINISH">FINISH</option>
                <option {{$orders->status == "CANCEL" ? "selected" : ""}}
                value="CANCEL">CANCEL</option>
                </select>
                <br>
                <input type="submit" class="btn btn-primary" value="Update">
            </form>
        </div>
    </div>
@endsection
