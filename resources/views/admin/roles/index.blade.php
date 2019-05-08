@extends('admin.layouts.app')
@section('content-header')
    <h1>
        Управление ролями
    </h1>

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                @can('role-create')
                    {{--<a class="btn btn-success" href="{{ route('roles.create') }}"> Create New Role</a>--}}
                @endcan
            </div>
        </div>
    </div>



    <table class="table table-hover table-striped text-center">
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
                    <a href="" class="btn btn-info"> <i class="fa fa-eye"></i>  </a>

                    <form method="post" action=""
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

                </td>
            </tr>
        @endforeach
    </table>


    {!! $roles->render() !!}
@endsection
@section('content')

@endsection