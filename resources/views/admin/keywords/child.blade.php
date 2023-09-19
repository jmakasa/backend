<li>{{ $child->name[Config::get('app.locale')] }}&nbsp; <a href="{{ route('admin.keywords_edit',[
                            'locale' => app()->getLocale(),
                            'keywords_id'=>$child->id
                            ]) }}" >
                            <i class="fa fa-edit"></i>
                                    </a></li>
@if ($child->keywords)
    <ul>
        @foreach ($child->keywords as $childKeywords)
            @include('admin.keywords.child', ['child' => $childKeywords])
        @endforeach
    </ul>
@endif