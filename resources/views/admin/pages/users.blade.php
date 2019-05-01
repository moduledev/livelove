@extends('admin.layouts.app')
@section('content-header')
    <h1>
        Пользователи
    </h1>
   {{ Breadcrumbs::render('users') }}
@endsection
@section('content')
    <div class="row">
       <div class="col-xs-12">
           @isset($users)
               <table class="table table-hover">
                   <thead>
                   <tr>
                       <th>ID</th>
                       <th>Имя</th>
                       <th>Телефон</th>
                       <th>Должность</th>
                       <th>Аватарка</th>
                   </tr>
                   </thead>
                   <tbody>
                   @foreach($users as $user)
                       <tr>
                           <td>{{$user->id}}</td>
                           <td>{{$user->name}}</td>
                           <td>{{$user->phone}}</td>
                           <td>{{$user->posistiob}}</td>
                           <td><img src="{{asset('storage/' . $user->image)}}" class="img-responsive" alt="" style="width: 100px;height: 100px"></td>
                           <td>
                               <div class="d-inline">
                                   <form method="post" action="{{ route('admin.user.delete') }}">
                                       {!! csrf_field() !!}
                                       <input type="hidden" name="id" value="{{$user->id}}">
                                       <button href="#" class="btn btn-danger" type="submit"> <i class="fa fa-trash"></i> </button>
                                   </form>

                                   <a href="#" class="btn" type="submit"></a>
                                   <a href="#" class="btn" type="submit"></a>
                               </div>
                           </td>
                       </tr>
                   @endforeach
                   </tbody>
               </table>
           @endisset
       </div>
    </div>
@endsection