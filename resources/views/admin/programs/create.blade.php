@extends('admin.layouts.app')
@section('content-header')
    <h1>
        Создать программу
    </h1>
     {{ Breadcrumbs::render('create-programs') }}
@endsection
@section('content')
    <section id="app">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Добавить новую программу</h3>
                        <div class="box-body">
                                <form class="form-horizontal" method="POST" action="{{route('add.program')}}" enctype="multipart/form-data"
                                {{--:class="{error_group: startTimeError, error_group: finishTimeError}">--}}
                                :class="[startTimeError ? 'error_group' : '',finishTimeError ? 'error_group' : '']">
                              {{ csrf_field() }}
          
                              <div class="form-group">
                                  <label class="control-label col-sm-2" for="image">Добавить фото:</label>
                                  <div class="col-xs-6">
                                      <input type="file" name="image" class="form-control">
                                  </div>
                              </div>
                              @if ($errors->has('image'))
                                  <div class="form-group error_group">
                                      <div class="col-xs-10 col-sm-offset-2">
                                          <p class="error_element">{{$errors->first('image')}}</p>
                                      </div>
                                      @endif
                                      <div class="form-group">
                                          <label class="control-label col-sm-2" for="name">Название:</label>
                                          <div class="col-xs-6">
                                              <input type="text" name="name" class="form-control" placeholder="Название">
                                          </div>
                                      </div>
                                      <div class="form-group" >
                                          <label class="control-label col-sm-2" for="started">Старт программы:</label>
                                          <div class="col-xs-3">
                                              <input type="date"
                                                     name="started"
                                                     class="form-control" placeholder="Имя"
                                                     :class="{error_input: startTimeError}"
                                                     @change="start(startTime)"
                                                     v-model="startTime" >
                                          </div>
                                          <template v-if="startTimeError">
                                              <div class="col-sm-10 col-sm-offset-2">
                                                  <p class="error_element">@{{errorStartTimeMessage}}</p>
                                              </div>
                                          </template>
                                      </div>
                                      @if ($message = Session::get('started_error'))
                                          <div class="form-group error_group">
                                              <div class="col-xs-10 col-sm-offset-2">
                                                  <p class="error_element">{{ $message }}</p>
                                              </div>
                                              @endif
                                              <div class="form-group">
                                                  <label class="control-label col-sm-2" for="finished">Окончание программы:</label>
                                                  <div class="col-xs-3">
                                                      <input type="date"
                                                             name="finished"
                                                             placeholder="Имя"
                                                             class="form-control"
                                                             :class="{error_input: finishTimeError}"
                                                             @change="finish(finishTime)"
                                                             v-model="finishTime">
                                                  </div>
                                                  <template v-if="finishTimeError">
                                                      <div class="col-sm-10 col-sm-offset-2">
                                                          <p class="error_element">@{{errorFinishTimeMessage}}</p>
                                                      </div>
                                                  </template>
                                              </div>
                                              @if ($message = Session::get('finished_error'))
                                                  <div class="form-group">
                                                      <div class="col-xs-10 col-sm-offset-2">
                                                          <p class="alert alert-error">{{ $message }}</p>
                                                      </div>
                                                      @endif
                                                      <div class="form-group">
                                                          <label class="control-label col-sm-2" for="description">Описание:</label>
                                                          <div class="col-sm-10">
                                  <textarea class="form-control" name="description" id="summernote" placeholder="Описание программы"
                                            cols="5"></textarea>
                                                          </div>
                                                      </div>
                                                      <div class="form-group">
                                                          <div class="col-sm-offset-2 col-sm-10">
                                                              <button type="submit" :class="{error_btn: finishTimeError,error_btn: startTimeError }" class="btn btn-default"
                                                                      :disabled="finishTimeError||startTimeError">Добавить</button>
                                                          </div>
                                                      </div>
                          </form>
                        </div>
                    </div>
                </div>  
               
            </div>
          
        </div>
    </section>
    <script src="{{asset('js/program.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#summernote').summernote();
        });
    </script>
@endsection