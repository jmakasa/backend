@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('New') }} {{ __('Category.category') }}</div>

                <div class="card-body">
                    <form name="add-category-form" id="add-category-form" method="post" action="{{ route('admin.category_update',app()->getLocale()) }}">
                        @csrf
                        <input type="hidden" name="id" value="{{$getCategory->id}}">
                        <div class="container">
                            <div class="row">
                                <label for="category_name">{{__('category.name')}}</label>
                                @foreach (Config::get('app.locales') as $locale)
                                <div class="col-sm">
                                    <label for="category_name">{{$locale}}</label>
                                    <input type="text" class="form-control" placeholder="{{$locale}}" name="name[{{$locale}}]" value="{{$getCategory->name[$locale]}}">
                                </div>
                                @endforeach
                            </div>

                            <div class="form-group">
                            <label for="parent_id">{{__('category.parent')}}</label>
                                <select  name="parent_id" class="form-select">
                                <option value="">--</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ ($category->id == $getCategory->parent_id ? "selected" : "")}} ><h4>{{ $category->name[Config::get('app.locale')] }}</h4></option>
                                        @foreach ($category->children as $child)
                                            @include('admin.category.select_child', ['child' => $child])
                                        @endforeach
                                     @endforeach
                                    </select>
                            </div>
                            @include('admin.select_status', ['data' => $getCategory])
                            
                            <div class="form-group">
                                <label for="seq">{{__('general.seq')}}</label>
                                <input type="text" id="seq" class="form-control" placeholder="01" name="seq"  value="{{$getCategory->seq}}">
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