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
            <div class="box">
                <div class="box-body">
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
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-default">Изменить</button>
                                    </div>
                                </div>
                            </form>
                </div>
            </div>
            
        </div>
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Управление ролями администратора</h3>
                </div>
                <div class="box-body">
                        <div class="form-group">
                                <label class="control-label col-sm-2">Выберите роль:</label>
                                <div class="col-sm-10">
                                    <form action="{{route('assign.role')}}" method="post" class="form-horizontal">
                                        {{ csrf_field() }}
                                        {{ method_field('PUT') }}
                
                                        <div class="form-group col-xs-6">
                                            <input type="hidden" value="{{$admin->id}}" name="user">
                                            <select class="form-control" name="role" id="sel1" >
                                                <option>Выберите роль</option>
                                                @foreach($roles as $role)
                                                    <option value="{{$role->name}}">{{$role->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-xs-6"> <button class="btn btn-success" ><i class=" fa fa-plus"></i></button>  </div>
                                    </form>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2">Доступные роли:</label>
                                <div class="col-sm-10">
                                    @foreach($adminsRoles as $adminRole)
                                        <form action="{{route('remove.role')}}" method="post" class="delete_role_form">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="user" value="{{$admin->id}}">
                                            <label class="checkbox-inline position-relative">
                                                <span>{{$adminRole->name}}</span>
                                                <button class="btn btn-danger delete_role_btn" type="submit" name="role" value="{{$adminRole->name}}"> <i class="fa fa-trash"></i>
                                                </button>
                                            </label>
                                        </form>
                                    @endforeach
                
                                </div>
                            </div>
                </div>
            </div>  
            
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#summernote').summernote();
        });
    </script>
@endsection