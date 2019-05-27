@extends('admin.layouts.app')
@section('content-header')
    <h1>
        Управление ролями
    </h1>

    <div class="row">
        <div class="col-xs-12">
            <h3>Добавить роль:</h3>
           <div class="box">
               <div class="box-body">
                    <form method="POST" class="form-inline" action="{{route('add.role')}}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="name">Название:</label>
                                <input id="name" type="text" class="form-control" name="role">
                            </div>
                            <button type="submit" class="btn btn-default">Добавить <i class="fa fa-plus"></i> </button>
                        </form>
               </div>
           </div>
           <div class="box">
               <div class="box-header">
                   <h3 class="box-title">
                       Cписок ролей
                   </h3>
                   <div class="box-body">
                        <table class="table table-bordered table-hover  dataTable">
                                <tr>
                                    <th>Id</th>
                                    <th>Название</th>
                                    <th>Операции</th>
                                </tr>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>{{$role->id}}</td>
                                        <td>{{$role->name}}</td>
                                        <td>
                                            <div class="text-center">
                                            <a href="{{route('show.role',$role->id)}}" class="btn btn-info"> <i class="fa fa-eye"></i>  </a>
                        
                                            <form method="post" action="{{route('delete.role')}}"
                                                  style="display: inline-block">
                                                {!! csrf_field() !!}
                                                {{ method_field('DELETE') }}
                                                <input type="hidden" name="id" value="{{$role->id}}">
                                                <button href="#" class="btn btn-danger" type="submit"><i
                                                            class="fa fa-trash"></i></button>
                                            </form>
                        
                                            <form method="get" action="{{route('admin.role.edit', $role->id)}}"
                                                  style="display: inline-block">
                                                <button href="#" class="btn btn-success" type="submit"><i
                                                            class="fa fa-pencil-square"></i></button>
                                            </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                   </div>
               </div>
           </div>
        </div>
    </div>

    {!! $roles->render() !!}
@endsection
@section('content')

@endsection