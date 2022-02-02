@extends('dashboard.layouts.layout')

@section('body')
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">{{__('words.dashboard')}}</li>
        <li class="breadcrumb-item"><a href="#">{{ __('words.posts') }}</a>
        </li>
        <li class="breadcrumb-item active">{{ __('words.edit posts') }}</li>

        <!-- Breadcrumb Menu-->
        


    <div class="container-fluid">

        <div class="animated fadeIn">
            <form action="{{ Route('dashboard.posts.update',$post) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <strong>{{ __('words.posts') }}</strong>
                        </div>
                        <div class="card-block">

                            <div class="form-group col-md-12">
                            <img src="{{ asset($post->image) }}" alt="" height="50px;">
                            </div>

                            <div class="form-group col-md-12">
                                <label>{{ __('words.image') }}</label>
                                <input type="file" name="image" class="form-control" placeholder="{{ __('words.image') }}">
                            </div>
                            
                    
                            <div class="form-group col-md-12">
                                <label>{{__('words.parent')}}</label>
                                <select name="category_id" id="" class="form-control" required>
                                    @foreach ($categories as $item)
                                       <option @selected($post->category_id == $item->id) value="{{$item->id}}">{{$item->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <strong>Translation</strong>
                            </div>
                            <div class="card-block">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">

                                    @foreach (config('app.languages') as $key => $lang)
                                        <li class="nav-item">   
                                            <a class="nav-link @if ($loop->index == 0) active @endif"
                                                id="home-tab" data-toggle="tab" href="#{{ $key }}" role="tab"
                                                aria-controls="home" aria-selected="true">{{ $lang }}</a>
                                        </li>
                                    @endforeach

                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    @foreach (config('app.languages') as $key => $lang)
                                        <div class="tab-pane mt-3 fade @if ($loop->index == 0) show active in @endif"
                                            id="{{ $key }}" role="tabpanel" aria-labelledby="home-tab">
                                            <br>
                                            <div class="form-group mt-3 col-md-12">
                                                <label>{{ __('words.Lang') }} - {{ $lang }}</label>
                                                <input type="text" name="{{ $key }}[title]" class="form-control"
                                                    placeholder="{{ __('words.title') }}" value="{{ $post->translate($key)->title }}" >
                                            </div>
                                            <div class="form-group mt-3 col-md-12">
                                                <label>{{__('words.smallDesc')}}</label>
                                                <textarea class="form-control" name="{{$key}}[smallDesc]" id="editor"></textarea>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label>{{ __('words.content') }}</label>
                                                <textarea name="{{ $key }}[content]" id="editor" class="form-control" cols="30" rows="10"> </textarea>
                                            </div>

                                            <div class="form-group mt-3 col-md-12">
                                                <label>{{ __('words.tags') }}</label>
                                                <input type="text" name="{{ $key }}[tags]" class="form-control"
                                                    placeholder="{{ __('words.tags') }}" value="{{ $post->translate($key)->tags }}" >
                                            </div>
                                        </div>
                                    @endforeach

                                </div>



                            </div>


                            <div class="card-footer">
                                <button type="submit" class="btn btn-sm btn-primary"> <i class="fa fa-dot-circle-o"> </i>
                                    Submit</button>
                                <button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i>
                                    Reset</button>
                            </div>

                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i>
                                Submit</button>
                        </div>

                    </div>
            </form>
        </div>
    </div>
@endsection
