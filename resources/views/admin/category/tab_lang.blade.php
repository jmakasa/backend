<div class="form-group">
    <div class="nav nav-tabs bg-warning " id="nav-tab" role="tablist">
        @foreach (Config::get('app.locales') as $locale)
        <button class="nav-link {{$loop->first ? 'active' : ''}}" id="nav-{{$locale}}-content-tab" data-bs-toggle="tab" data-bs-target="#nav-{{$locale}}-content" type="button" role="tab" aria-controls="nav-{{$locale}}-content" {{$loop->first ? 'aria-selected="true"' : ''}}>{{$locale}}</button>
        @endforeach
    </div>
    <div class="tab-content" id="nav-tabContent">
        @foreach (Config::get('app.locales') as $locale)
        <div class="tab-pane fade  {{$loop->first ? 'show active' : ''}}" id="nav-{{$locale}}-content" role="tabpanel" aria-labelledby="nav-{{$locale}}-content-tab">
            <div class="form-group">
                <label for="category_name">{{__('general.category.name')}}</label>
                {{--<input type="text" class="form-control" placeholder="{{$locale}}" name="name[{{$locale}}]" 
                value="{{(isset($getCategory->name) && (array_key_exists($locale,$getCategory->name)) ? $getCategory->name[$locale] : '')}}">--}}
                <textarea class="form-control"  name="name[{{$locale}}]" id="editor-name-{{$locale}}">{{(isset($getCategory->name) && array_key_exists($locale,$getCategory->name)) ? $getCategory->name[$locale] : ''}}
                </textarea>
            </div>
            <div class="form-group">
                <label for="editor{{$locale}}">{{__('general.category.desc')}}</label>
                <textarea class="form-control"  name="desc[{{$locale}}]" id="editor-content-{{$locale}}">{{(isset($getCategory->desc) && array_key_exists($locale,$getCategory->desc)) ? $getCategory->desc[$locale] : ''}}
                </textarea>
            </div>
        </div>
        @endforeach
    </div>
</div>