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
                <label for="name-{{$locale}}">{{__('general.products.name')}}</label>
                <input type="text" id="name-" class="form-control" placeholder="{{$locale}}" name="name[{{$locale}}]">
            </div>
            <div class="form-group">
                <label for="title-{{$locale}}">{{__('general.products.title')}}</label>
                <input type="text" id="title-{{$locale}}" class="form-control" placeholder="{{$locale}}" name="title[{{$locale}}]">
            </div>
            <div class="form-group">
                <label for="editor-intro-{{$locale}}">{{__('general.products.intro')}}</label>
                <textarea class="col-sm-10" name="editor_intro[{{$locale}}]" id="editor-intro-{{$locale}}"></textarea>
            </div>
            <div class="form-group">
                <label for="editor-content-{{$locale}}">{{__('general.products.content')}}</label>
                <textarea class="col-sm-10" name="editor_content[{{$locale}}]" id="editor-content-{{$locale}}"></textarea>
            </div>
            <div class="form-group">
                <label for="editor-spec-{{$locale}}">{{__('general.products.spec')}}</label>
                <textarea class="col-sm-10" name="editor_spec[{{$locale}}]" id="editor-spec-{{$locale}}"></textarea>
            </div>
        </div>
        @endforeach
    </div>
</div>