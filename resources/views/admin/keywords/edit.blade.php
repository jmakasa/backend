@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('general.edit') }} {{ __('general.keywords.name') }}</div>

                <div class="card-body">
                    <form name="add-keywords-form" id="add-keywords-form" method="post" action="{{ route('admin.keywords_update',app()->getLocale()) }}">
                        @csrf
                        <input type="hidden" name="id" value="{{$getKeyword->id}}">
                        <div class="container">
                            <div class="row">
                                <label for="keyword_name">{{__('general.keywords.name')}}</label>
                                @foreach (Config::get('app.locales') as $locale)
                                <div class="col-sm">
                                    <label for="keyword_name">{{$locale}}</label>
                                    <input type="text" class="form-control" placeholder="{{$locale}}" name="name[{{$locale}}]" value="{{$getKeyword->name[$locale]}}">
                                </div>
                                @endforeach
                            </div>
                            <div class="row">
                                <label for="keyword_name">{{__('general.keywords.display_name')}}</label>
                                @foreach (Config::get('app.locales') as $locale)
                                <div class="col-sm">
                                    <label for="keyword_name">{{$locale}}</label>
                                    <input type="text" class="form-control" placeholder="{{$locale}}" name="display_name[{{$locale}}]" value="{{$getKeyword->display_name[$locale]}}">
                                </div>
                                @endforeach
                            </div>

                            <div class="form-group">
                            <label for="parent_id">{{__('general.keywords.parent')}}</label>
                                <select  name="parent_id" class="form-select">
                                <option value="">--</option>
                                    @foreach($keywords as $keyword)
                                        <option value="{{ $keyword->id }}" {{ ($keyword->id == $getKeyword->parent_id ? "selected" : "")}} ><h4>{{ $keyword->name[Config::get('app.locale')] }}</h4></option>
                                        @foreach ($keyword->children as $child)
                                            @include('admin.keywords.select_child', ['child' => $child])
                                        @endforeach
                                     @endforeach
                                    </select>
                            </div>
                            @include('admin.select_status', ['data' => $getKeyword])
                            
                            <div class="form-group">
                                <label for="seq">{{__('general.seq')}}</label>
                                <input type="text" id="seq" class="form-control" placeholder="01" name="seq"  value="{{$getKeyword->seq}}">
                            </div>
                            <br>
                            <div class="form-group">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">{{ __('Edit') }} </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>



            </div>
        </div>
    </div>
</div>
</div>
@endsection