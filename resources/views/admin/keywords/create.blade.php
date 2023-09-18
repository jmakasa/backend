@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('New') }} {{ __('general.keywords.name') }}</div>

                <div class="card-body">
                    <form name="add-keywords-form" id="add-keywords-form" method="post" action="{{ route('admin.keywords_store',app()->getLocale()) }}">
                        @csrf
                        <div class="container">
                            <div class="row">
                                <label for="keywords_name">{{__('general.keywords.name')}}</label>
                                @foreach (Config::get('app.locales') as $locale)
                                <div class="col-sm">
                                    <label for="keywords_name">{{$locale}}</label>
                                    <input type="text" id="keywords_name" class="form-control" placeholder="{{$locale}}" name="name[{{$locale}}]">
                                </div>
                                @endforeach
                            </div>
                            <div class="row">
                                <label for="keywords_name">{{__('general.keywords.display_name')}}</label>
                                @foreach (Config::get('app.locales') as $locale)
                                <div class="col-sm">
                                    <label for="keywords_display_name">{{$locale}}</label>
                                    <input type="text" id="keywords_display_name" class="form-control" placeholder="{{$locale}}" name="display_name[{{$locale}}]">
                                </div>
                                @endforeach
                            </div>

                            <div class="form-group">
                            <label for="parent_id">{{__('general.keywords.parent')}}</label>
                                <select id="parent_id" name="parent_id" class="form-select">
                                <option value="">--</option>
                                    @foreach($keywords as $keyword)
                                        <option value="{{ $keyword->id }}"><h4>{{ $keyword->name[Config::get('app.locale')] }}</h4></option>
                                        @foreach ($keyword->children as $child)
                                            @include('admin.keywords.select_child', ['child' => $child])
                                        @endforeach
                                     @endforeach
                                    </select>
                            </div>
                            <div class="form-group">
                                <label for="seq">{{__('general.seq')}}</label>
                                <input type="text" id="seq" class="form-control" placeholder="01" name="seq">
                            </div>
                            <br>
                            <div class="form-group">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Sign in</button>
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