@extends('admin.layouts.app')
@section('content-header')
    <h1>
        Программы
    </h1>
   {{-- {{ Breadcrumbs::render('users') }} --}}
@endsection
@section('content')

    <div class="row">
       <div class="col-xs-12">
           @isset($programs)
               <table class="table table-hover">
                   <thead>
                   <tr>
                       <th>ID</th>
                       <th>Название</th>
                       <th>Время проведения</th>
                       <th>Операция</th>
                   </tr>
                   </thead>
                   <tbody>
                   @foreach($programs as $program)
                       <tr>
                           <td>{{$program->id}}</td>
                           <td>{{$program->name}}</td>
                           <td>{{$program->term}}</td>
                           <td>
                               <div >
                                   <form method="post" action="{{ route('admin.user.delete') }}" style="display: inline-block">
                                       {!! csrf_field() !!}
                                       <input type="hidden" name="id" value="{{$program->id}}">
                                       <button href="#" class="btn btn-danger" type="submit"> <i class="fa fa-trash"></i> </button>
                                   </form>

                                   <form method="get" action="{{ route('admin.user.edit',$program->id) }}" style="display: inline-block">
                                       <button href="#" class="btn btn-success" type="submit"> <i class="fa fa-pencil-square"></i> </button>
                                   </form>

                                   <a href="#" class="btn" type="submit"></a>
                                   <a href="#" class="btn" type="submit"></a>
                               </div>
                   @endforeach
                   </tbody>
               </table>
           @endisset
               {{ $programs->appends(['term'])->links() }}
       </div>
    </div>
@endsection