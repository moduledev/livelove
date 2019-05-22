@extends('admin.layouts.app')
@section('content-header')
    <h1>
        Изменить роль
    </h1>
    {{ Breadcrumbs::render('edit',$role->id) }}
@endsection
@section('content')

    <div class="row">
        <div class="col-xs-12">

            <div class="box">
                <div class="box-body">
                    <div class="box-header">
                        <h3 class="box-title">Изменить роль</h3>
                    </div>
                        <form class="form-horizontal" method="POST" action="{{route('admin.roles.update',$role->id)}}">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="email">Имя:</label>
                                    <div class="col-sm-10">
                                        <input value="{{$role->name}}" type="text" name="name" class="form-control" placeholder="Имя">
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
                    <h3 class="box-title">Добавить/удалить permission</h3>
                    <div class="box-body">
                            <div class="form-group">
                                    <label class="control-label col-sm-2">Выберите permission:</label>
                                    <div class="col-sm-10">
                                        <form action="{{route('assign.permission')}}" method="post" class="form-horizontal">
                                            {{ csrf_field() }}
                                            {{ method_field('PUT') }}
                    
                                            <div class="form-group col-xs-6">
                                                <input type="hidden" value="{{$role->id}}" name="role">
                                                <select class="form-control" name="permission" id="sel1" >
                                                    <option>Выберите permission</option>
                                                    @foreach($permissions as $per)
                                                        <option value="{{$per->name}}">{{$per->name}}</option>
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
                                        @foreach($userPermissions as $permission)
                                            <form action="{{route('remove.permission')}}" method="post" class="delete_role_form">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="role" value="{{$role->id}}">
                                                <label class="checkbox-inline position-relative">
                                                    <span>{{$permission->name}}</span>
                                                    <button class="btn btn-danger delete_role_btn" type="submit" name="permission" value="{{$permission->name}}"> <i class="fa fa-trash"></i>
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
    </div>
@endsection