@extends('dashboard.layouts.layout')

@section('body')
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">{{__('words.dashboard')}}</li>
        <li class="breadcrumb-item"><a href="#">{{ __('words.category') }}</a>
        </li>
        <li class="breadcrumb-item active">{{ __('words.edit category') }}</li>

        <!-- Breadcrumb Menu-->
        <li class="breadcrumb-menu">
            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                <a class="btn btn-secondary" href="#"><i class="icon-speech"></i></a>
                <a class="btn btn-secondary" href="./"><i class="icon-graph"></i> &nbsp;{{ __('words.categories') }}</a>
                <a class="btn btn-secondary" href="#"><i class="icon-settings"></i> &nbsp;{{ __('words.edit categories') }}</a>
            </div>
        </li>
    </ol>


    <div class="container-fluid">

        <div class="animated fadeIn">
            <form action="{{ Route('dashboard.categories.update',$category) }}" method="post" enctype="multipart/form-data">
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
                            <strong>{{ __('words.categories') }}</strong>
                        </div>
                        <div class="card-block">

                            <div class="form-group col-md-12">
                            <img src="{{ asset($category->image) }}" alt="" height="50px;">
                            </div>

                            <div class="form-group col-md-12">
                                <label>{{ __('words.image') }}</label>
                                <input type="file" name="image" class="form-control" placeholder="{{ __('words.image') }}">
                            </div>
                            
                    
                            <div class="form-group col-md-12">
                                <label>{{ __('words.parent') }}</label>
                                <select name="parent" id="" class="form-control">
                                    <option value="0" @if ($category->parent == 0 || $category->parent==null)
                                        selected
                                    @endif >القسم الرئيسي</option>
                                    @foreach ($categories as $item)
                                        @if ($item->id != $category->id)
                                            <option @if ($category->parent == $item->id)
                                            selected
                                                @endif value="{{$item->id}}">{{ $item->title}}</option>
                                        @endif
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
                                                    placeholder="{{ __('words.title') }}" value="{{ $category->translate()->title }}" >
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label>{{ __('words.content') }}</label>
                                                <textarea name="{{ $key }}[content]" class="form-control" cols="30" rows="10"> </textarea>
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
