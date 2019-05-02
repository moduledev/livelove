@extends('admin.layouts.app')
@section('content-header')
    <h1>
        Администраторы
    </h1>
    {{ Breadcrumbs::render('admins') }}
@endsection
@section('content')

    <div class="row">
        <div class="col-xs-12">
            @isset($admins)
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Имя</th>
                        <th>Роль</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($admins as $admin)
                        <tr>
                            <td>{{$admin->id}}</td>
                            <td>{{$admin->name}}</td>
                            <td></td>
{{--                            <td>{{$admin->position}}</td>--}}
                            {{--<td><img src="{{asset('storage/' . $user->image)}}" class="img-responsive" alt="" style="width: 100px;height: 100px"></td>--}}
                            <td>
                                <div >
                                    <form method="post" action="{{ route('admin.user.delete') }}" style="display: inline-block">
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="id" value="{{$admin->id}}">
                                        <button href="#" class="btn btn-danger" type="submit"> <i class="fa fa-trash"></i> </button>
                                    </form>

                                    <form method="get" action="{{ route('admin.admins.edit',$admin->id) }}" style="display: inline-block">
                                        <button href="#" class="btn btn-danger" type="submit"> <i class="fa fa-pencil-square"></i> </button>
                                    </form>

                                    <a href="#" class="btn" type="submit"></a>
                                    <a href="#" class="btn" type="submit"></a>
                                </div>
                    @endforeach
                    </tbody>
                </table>
            @endisset
            {{ $admins->links() }}
        </div>
    </div>
@endsection