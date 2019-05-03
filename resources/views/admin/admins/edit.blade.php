@extends('admin.layouts.app')
@section('content-header')
    <h1>
        Изменить данные администратора
    </h1>
        {{ Breadcrumbs::render('edit',$admin->id) }}
@endsection
@section('content')

    <div class="row">
        <div class="col-xs-12">
            <form class="form-horizontal" method="POST" action="{{route('admin.admins.update',$admin->id)}}">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="form-group">
                    <label class="control-label col-sm-2" for="email">Имя:</label>
                    <div class="col-sm-10">
                        <input value="{{$admin->name}}" type="text" name="name" class="form-control" placeholder="Имя">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="email">Email:</label>
                    <div class="col-sm-10">
                        <input value="{{$admin->email}}" type="email" name="email" class="form-control" placeholder="Email">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="pwd">Password:</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter password">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2">Выберите роль:</label>
                    <div class="col-sm-10">

                        <select class="form-control" name="role" id="sel1">
                            {{--@foreach($roles as $role)--}}
                            {{--<option>{{$role->name}}</option>--}}
                            {{--@endforeach--}}
                        </select>
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