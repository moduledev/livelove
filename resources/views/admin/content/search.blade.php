@extends('admin.layouts.app')
@section('content-header')
    <h1>
        Результат поиска:
    </h1>
    {{ Breadcrumbs::render('search') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <form action="{{route('search')}}" class="form-horizontal" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <label class="control-label col-sm-2" for="image">Найти:</label>
                    <div class="col-sm-6">
                        <input type="search" name="q" class="form-control">
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-default">Найти <i class="fa fa-search"></i></button>
                    </div>
                </div>

            </form>
            @isset($q)
            <p> Результат по запросу <b> {{ $q }} </b>:</p>
            @endisset
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            @isset($details)
                <table class="table table-hover table-striped text-center">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Имя</th>
                        <th>Телефон</th>
                        <th>Должность</th>
                        <th>Операция</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($details as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->phone}}</td>
                            <td>{{$user->position}}</td>
                            {{--<td><img src="{{asset('storage/' . $user->image)}}" class="img-responsive" alt="" style="width: 100px;height: 100px"></td>--}}
                            <td>
                                <div class=" text-center">
                                    <a href="{{route('admin.user.show', $user->id)}}" class="btn btn-info"> <i class="fa fa-eye"></i> </a>

                                    <form method="post" action="{{ route('admin.user.delete') }}" style="display: inline-block">
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="id" value="{{$user->id}}">
                                        <button href="#" class="btn btn-danger" type="submit"> <i class="fa fa-trash"></i> </button>
                                    </form>

                                    <form method="get" action="{{ route('admin.user.edit',$user->id) }}" style="display: inline-block">
                                        <button href="#" class="btn btn-success" type="submit"> <i class="fa fa-pencil-square"></i> </button>
                                    </form>

                                </div>
                    @endforeach
                    </tbody>
                </table>
            @endisset
{{--            {{ $users->links() }}--}}
        </div>
    </div>
@endsection