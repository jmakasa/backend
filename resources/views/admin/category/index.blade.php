@extends('layouts.admin')

@section('content')
<script>
    /*
    let x = document.cookie;
    console.log(x);

    function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }


    $('#tt').tree({
        url: "{{ route('api.category.list',app()->getLocale()); }}",
        method: 'GET',
        queryParams: {
            'Authorization': "Bearer " + getCookie('token')
        }
    });
    */
</script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif
            <div class="card">
                <div class="card-header  text-white bg-dark ">{{ __('Category.category') }}&nbsp;&nbsp;&nbsp;
                    <a class="btn btn-primary btn-sm" href="{{ route('admin.category_create',app()->getLocale()) }}">
                        <i class="fa fa-plus-square"></i> {{ __('general.add') }}
                    </a>
                </div>

                <div class="card-body">
                    <ul class="easyui-tree">
                        @foreach ($categories as $category)
                        <li><span>{!! strip_tags($category->name[Config::get('app.locale')] )!!} &nbsp; <a href="{{ route('admin.category_edit',[
                            'locale' => app()->getLocale(),
                            'category_id'=>$category->id
                            ]) }}">
                                <i class="fa fa-edit"></i>
                            </a></span>
                        @if (isset($category->children))
                            <ul>
                            @foreach ($category->children as $child)
                            @include('admin.category.child', ['child' => $child])
                            @endforeach
                            </ul>
                        @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection