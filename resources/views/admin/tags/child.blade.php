<li>{{ $child->name[Config::get('app.locale')] }}&nbsp; <a href="{{ route('admin.tags_edit',[
                            'locale' => app()->getLocale(),
                            'tags_id'=>$child->id
                            ]) }}" >
                            <i class="fa fa-edit"></i>
                                    </a></li>
@if ($child->tags)
    <ul>
        @foreach ($child->tags as $childKeywords)
            @include('admin.tags.child', ['child' => $childKeywords])
        @endforeach
    </ul>
@endif