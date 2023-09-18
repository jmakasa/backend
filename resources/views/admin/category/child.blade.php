<li><span>{!! strip_tags($child->name[Config::get('app.locale')] )!!}&nbsp; <a href="{{ route('admin.category_edit',[
                            'locale' => app()->getLocale(),
                            'category_id'=>$child->id
                            ]) }}" >
                            <i class="fa fa-edit"></i>
                                    </a></span>
                                  
@if ($child->children)
    <ul>
        @foreach ($child->children as $childCategory)
            @include('admin.category.child', ['child' => $childCategory])
        @endforeach
    </ul>
@endif
</li>