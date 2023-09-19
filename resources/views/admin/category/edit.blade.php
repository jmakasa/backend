@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('general.edit') }} {{ __('Category.category') }}</div>

                <div class="card-body">
                    <form name="add-category-form" id="add-category-form" method="post" action="{{ route('admin.category_update',app()->getLocale()) }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{$getCategory->id}}">
                        <div class="row">
                            <div class="col-md-8">
                                @include('admin.category.tab_lang', ['getCategory' => $getCategory])
                            </div>
                            <div class="col-md-4">
                            <div class="form-group">
                                    <label for="parent_id">{{__('category.parent')}}</label>
                                    <select name="parent_id" class="form-select">
                                        <option value="">--</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{$getCategory->parent_id == $category->id ? " Selected" : ""}}>
                                            <h4>{{ $category->name[Config::get('app.locale')] }}</h4>
                                        </option>
                                        @foreach ($category->children as $child)
                                        @include('admin.category.select_child', ['child' => $child])
                                        @endforeach
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="seq">{{__('general.upload_img')}}</label>
                                    <input type="file" id="seq" class="form-control" placeholder="01" name="img_file">
                                    @if ($getCategory->img)
                                    <img src="{{URL::to('/')}}/{{$getCategory->img}}" alt="tag">
                                    @endif
                                </div>
                                <hr>
                                
                                @include('admin.select_status', ['data' => $getCategory])
                                <hr>
                                <div class="form-check">
                                    <div>{{__('general.spec_css')}}</div>
                                    <input type="checkbox" class="form-check-input" id="spec_css" name="spec_css" value="dark" {{$getCategory->spec_css == "dark" ? " Checked" : ""}}>
                                    <label class="form-check-label" for="spec_css">Dark</label>
                                </div>
                                <div class="form-group">
                                    <label for="seq">{{__('general.seq')}}</label>
                                    <input type="text" id="seq" class="form-control" placeholder="01" name="seq" value="{{$getCategory->seq}}">
                                </div>
                            </div>
                        </div>

                </div>
                <div class="container">
                    <div class="form-group">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">{{ __('Edit') }} </button>
                        </div>
                    </div>
                    <br>
                </div>
                </form>
            </div>



        </div>
    </div>
</div>
</div>
</div>
<script>
    CKEDITOR.config.height = 150;
    CKEDITOR.config.width = 'auto';

    @foreach(Config::get('app.locales') as $locale)
    CKEDITOR.replace('editor-name-{{$locale}}');
    CKEDITOR.replace('editor-content-{{$locale}}');
    CKEDITOR.replace('editor-spec-{{$locale}}');

    @endforeach
</script>
@endsection