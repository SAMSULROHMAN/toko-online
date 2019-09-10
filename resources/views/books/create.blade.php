@extends('layouts.global')
@section('title') Create book @endsection
@section('content')
    @if(session('status'))
        <div class="alert alert-success">
            {{session('status')}}
        </div>
    @endif
    <div class="row">
        <div class="col-md-8">
            <form action="{{ route('books.store')}}" method="post" enctype="multipart/form-data" class="shadow-sm p-3 bg-white">
                @csrf
                <label for="title">Title</label> <br>
                <input value="{{old('title')}}"  type="text" class="form-control {{$errors->first('title') ? 'is-invalid' : ''}}" name="title"
                placeholder="Book title">
                <div class="invalid-feedback">
                    {{$errors->first('title')}}
                </div>
                <br>
                <label for="cover">Cover</label>
                <input type="file" class="form-control {{$errors->first('cover') ?
                'is-invalid' : ''}}" name="cover">
                <div class="invalid-feedback">
                    {{$errors->first('cover')}}
                </div>
                <br>
                <label for="description">Description</label><br>
                <textarea name="description" id="description" class="form-control {{$errors->first('description') ? 'is-invalid' : ''}}"
                placeholder="Give a description about this book">{{old('description')}}</textarea>
                <div class="invalid-feedback">
                    {{$errors->first('description')}}
                </div>
                <br>
                <label for="categories">Categories</label><br>
                <select name="categories[]" multiple id="categories" class="form-control">
                </select>
                <br><br/>
                <label for="stock">Stock</label><br>
                <input type="number" class="form-control {{$errors->first('stock') ? 'is-invalid' : ''}}" value="{{old('stock')}}" id="stock" name="stock"
                min=0 value=0>
                <div class="invalid-feedback">
                    {{$errors->first('stock')}}
                </div>
                <br>
                <label for="author">Author</label><br>
                <input type="text" value="{{old('author')}}" class="form-control {{$errors->first('author') ? 'is-invalid' : ''}}" name="author" id="author"
                placeholder="Book author">
                <div class="invalid-feedback">
                    {{$errors->first('author')}}
                </div>
                <br>
                <label for="publisher">Publisher</label> <br>
                <input type="text" value="{{old('publisher')}}" class="form-control {{$errors->first('publisher') ? 'is-invalid' : ''}}" id="publisher"
                name="publisher" placeholder="Book publisher">
                <div class="invalid-feedback">
                    {{ $errors->first('publisher')}}
                </div>
                <br>
                <label for="Price">Price</label> <br>
                <input type="number" value="{{ old('price')}}" class="form-control {{ $errors->first('price') ? 'is-invalid' : ''}}" name="price" id="price"
                placeholder="Book price">
                <div class="invalid-feedback">
                    {{ $errors->first('price') }}
                </div>
                <br>
                <button
                class="btn btn-primary"
                name="save_action"
                value="PUBLISH" type="submit">Publish</button>
                <button
                class="btn btn-secondary"
                name="save_action"
                value="DRAFT" type="submit">Save as draft</button>
            </form>
        </div>
    </div>
@endsection

@section('footer-scripts')
    <script>
        $('#categories').select2({
            ajax: {
                url: '{{ route("ajax.name")}}',
                processResults: function(data){
                    return {
                        results: data.map(function(item){
                            return {
                                id: item.id,
                                text: item.name}
                            })
                        }
                    }
                }
            });
    </script>
@endsection
