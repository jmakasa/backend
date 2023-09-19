@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('general.edit') }} {{ __('general.tags.name') }}</div>

                <div class="card-body">
                    <form name="add-tags-form" id="add-tags-form" method="post" action="{{ route('admin.tags_update',app()->getLocale()) }}">
                        @csrf
                        <input type="hidden" name="id" value="{{$getTag->id}}">
                        <div class="container">
                            <div class="row">
                                <label for="tag_name">{{__('general.tags.name')}}</label>
                                @foreach (Config::get('app.locales') as $locale)
                                <div class="col-sm">
                                    <label for="tag_name">{{$locale}}</label>
                                    <input type="text" class="form-control" placeholder="{{$locale}}" name="name[{{$locale}}]" value="{{$getTag->name[$locale]}}">
                                </div>
                                @endforeach
                            </div>

                            <div class="form-group">
                            <label for="parent_id">{{__('general.tags.parent')}}</label>
                                <select  name="parent_id" class="form-select">
                                <option value="">--</option>
                                    @foreach($tags as $tag)
                                        <option value="{{ $tag->id }}" {{ ($tag->id == $getTag->parent_id ? "selected" : "")}} ><h4>{{ $tag->name[Config::get('app.locale')] }}</h4></option>
                                        @foreach ($tag->children as $child)
                                            @include('admin.tags.select_child', ['child' => $child])
                                        @endforeach
                                     @endforeach
                                    </select>
                            </div>
                            @include('admin.select_status', ['data' => $getTag])
                            
                            <!--div class="form-group">
                                <label for="seq">{{__('general.seq')}}</label>
                                <input type="text" id="seq" class="form-control" placeholder="01" name="seq"  value="{{$getTag->seq}}">
                            </div-->
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