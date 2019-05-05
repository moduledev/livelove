@extends('admin.layouts.app')
@section('content-header')
    <h1>
        Изменить данные пользователя
    </h1>
        {{-- {{ Breadcrumbs::render('edit',$user->id) }} --}}
@endsection
@section('content')

    <div class="row">
        <div class="col-xs-12">
            <form class="form-horizontal" method="POST" action="{{route('admin.users.update',$user->id)}}" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="form-group">
                    <label class="control-label col-sm-2" for="email">Фото:</label>
                    <div class="image_container col-sm-10">
                        <img src="{{asset('storage/'. $user->image)}}" class="img-rounded img-responsive" alt="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="image">Изменить фото:</label>
                    <div class="col-sm-10">
                        <input value="{{$user->name}}" type="file" name="image" class="form-control" >
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="email">Имя:</label>
                    <div class="col-sm-10">
                        <input value="{{$user->name}}" type="text" name="name" class="form-control" placeholder="Имя">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="email">Телефон:</label>
                    <div class="col-sm-10">
                    <input  type="text" name="phone" value="{{$user->phone}}" class="form-control" placeholder="Телефон">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="phone">Должность:</label>
                    <div class="col-sm-10">
                    <input  type="text" name="position" value="{{$user->position}}" class="form-control" placeholder="Должность">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="biography">Биография:</label>
                    <div class="col-sm-10">
                    <textarea class="form-control" name="biography" id="biography" placeholder="Биография" cols="5">{{$user->biography}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Изменить</button>
                    </div>
                </div>
            </form>
        </div>
    
    </div>
@endsection