@extends('admin.layouts.app')
@section('content-header')
    <h1>
        Изменить данные пользователя
    </h1>
    {{-- {{ Breadcrumbs::render('edit',$user->id) }} --}}
@endsection
@section('content')

    <div class="row">
        <div class="col-xs-12 ">
            <div class="box">
                <div class="box-body">
                        <form class="form-horizontal" method="POST" action="{{route('admin.users.update',$user->id)}}"
                                enctype="multipart/form-data">
                              {{ csrf_field() }}
                              {{ method_field('PUT') }}
                              @isset($user->image)
                              <div class="form-group">
                                  <label class="control-label col-sm-2" for="email">Фото:</label>
                                  <div class="image_container col-sm-10">
                                      <img src="{{asset('storage/'. $user->image)}}" class="img-rounded img-responsive" alt="">
                                  </div>
                              </div>
                              @endisset
                              <div class="form-group">
                                  <label class="control-label col-sm-2" for="image">Изменить фото:</label>
                                  <div class="col-sm-10">
                                      <input value="{{$user->name}}" type="file" name="image" class="form-control">
                                  </div>
                              </div>
              
                              <div class="form-group">
                                  <label class="control-label col-sm-2" for="email">Имя:</label>
                                  <div class="col-sm-10">
                                      <input value="{{$user->name}}" type="text" name="name" class="form-control" placeholder="Имя">
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="control-label col-sm-2" for="email">Телефон:</label>
                                  <div class="col-sm-10">
                                      <input type="text" name="phone" value="{{$user->phone}}" class="form-control"
                                             placeholder="Телефон">
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="control-label col-sm-2" for="phone">Должность:</label>
                                  <div class="col-sm-10">
                                      <input type="text" name="position" value="{{$user->position}}" class="form-control"
                                             placeholder="Должность">
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="control-label col-sm-2" for="biography">Биография:</label>
                                  <div class="col-sm-10">
                                      <textarea class="form-control" name="biography" id="summernote" placeholder="Биография"
                                                cols="5">{{htmlspecialchars_decode($user->biography)}}</textarea>
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
                    <h3 class="box-title"></h3>
                    <div class="box-body">
                            <form action="{{route('assign.program')}}" method="post" class="form-horizontal">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                    
                                    <div class="form-group ">
                                        <label class="control-label col-sm-2" for="email">Прикрепить программу:</label>
                                        <div class="col-sm-8">
                                            <input type="hidden" value="{{$user->id}}" name="user">
                                            <select class="form-control" name="program" id="sel1">
                                                <option>Выберите программу</option>
                                                @foreach($programs as $prog)
                                                    <option value="{{$prog->id}}">{{$prog->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <button class="btn btn-success"><i class=" fa fa-plus"></i></button>
                                        </div>
                                    </div>
                    
                                </form>
                    </div>
                </div>
            </div>
            
        </div>

            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">
                                Программы пользователя:
                        </h3>
                    </div>
                    <div class="box-body">
                        @if(count($userPrograms) > 0)
                            <table class="table table-bordered table-hover dataTable">
                                    <thead>
                                        <tr>
                                            <td>Id</td>
                                            <td>Название</td>
                                            <td>Операция</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($userPrograms as $program)
                                        <tr>
                                            <td>{{$program->id}}</td>
                                            <td> <a href="{{route('show.program',$program->id)}}">{{$program->title}}</a></td>
                                            <td><form action="{{route('remove.program')}}" method="post" class="delete_role_form clearfix">
                                                    {{ csrf_field() }}
                                                    <div class="form-group ">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                            <input type="hidden" name="user" value="{{$user->id}}">
                                                            <button class="btn btn-danger delete_role_btn" type="submit" name="program"
                                                                    value="{{$program->id}}"><i class="fa fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                            <p>Пользователю еще не назначена ни одна программа.</p>
                        @endif
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