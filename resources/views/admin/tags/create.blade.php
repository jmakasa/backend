@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('New') }} {{ __('general.tags.name') }}</div>

                <div class="card-body">
                    <form name="add-tags-form" id="add-tags-form" method="post" action="{{ route('admin.tags_store',app()->getLocale()) }}">
                        @csrf
                        <div class="container">
                            <div class="row">
                                <label for="tags_name">{{__('general.tags.name')}}</label>
                                @foreach (Config::get('app.locales') as $locale)
                                <div class="col-sm">
                                    <label for="tags_name">{{$locale}}</label>
                                    <input type="text" id="tags_name" class="form-control" placeholder="{{$locale}}" name="name[{{$locale}}]">
                                </div>
                                @endforeach
                            </div>
                            <div class="row">
                                <label for="tags_name">{{__('general.tags.display_name')}}</label>
                                @foreach (Config::get('app.locales') as $locale)
                                <div class="col-sm">
                                    <label for="tags_display_name">{{$locale}}</label>
                                    <input type="text" id="tags_display_name" class="form-control" placeholder="{{$locale}}" name="display_name[{{$locale}}]">
                                </div>
                                @endforeach
                            </div>

                            <div class="form-group">
                            <label for="parent_id">{{__('general.tags.parent')}}</label>
                                <select id="parent_id" name="parent_id" class="form-select">
                                <option value="">--</option>
                                    @foreach($tags as $tag)
                                        <option value="{{ $tag->id }}"><h4>{{ $tag->name[Config::get('app.locale')] }}</h4></option>
                                        @foreach ($tag->children as $child)
                                            @include('admin.tags.select_child', ['child' => $child])
                                        @endforeach
                                     @endforeach
                                    </select>
                            </div>
                            <!--div class="form-group">
                                <label for="seq">{{__('general.seq')}}</label>
                                <input type="text" id="seq" class="form-control" placeholder="01" name="seq">
                            </div-->
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