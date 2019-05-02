@extends('admin.layouts.app')
@section('content-header')
    <h1>
        Изменить данные администратора
    </h1>
    {{--    {{ Breadcrumbs::render('users') }}--}}
@endsection
@section('content')

    <div class="row">
        <div class="col-xs-12">
            <form action="">
                <div class="input-group input-group-lg">
                    <span class="input-group-addon" id="sizing-addon1"><i class="fa fa-user"></i></span>
                    <input value="{{$admin->name}}" type="text" name="name" class="form-control" placeholder="Имя"
                           aria-describedby="sizing-addon1">
                </div>
                <div class="input-group input-group-lg">
                    <span class="input-group-addon" id="sizing-addon1">@</span>
                    <input value="{{$admin->email}}" type="email" name="email" class="form-control" placeholder="Email"
                           aria-describedby="sizing-addon1">
                </div>
                <div class="input-group input-group-lg">
                    <label for="sel1">Выберите роль:</label>
                    <select class="form-control" name="role" id="sel1">
                        @foreach($roles as $role)
                            <option>{{$role->name}}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
    </div>
@endsection