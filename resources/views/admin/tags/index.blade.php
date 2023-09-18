@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif
            <div class="card">
                <div class="card-header  text-white bg-dark ">{{ __('general.tags.name') }}&nbsp;&nbsp;&nbsp;
                    <a class="btn btn-primary btn-sm" href="{{ route('admin.tags_create',app()->getLocale()) }}">
                        <i class="fa fa-plus-square"></i> {{ __('general.add') }}
                    </a>
                </div>

                <div class="card-body">
                    <ul class="list-unstyled">
                        @foreach ($tags as $tag)
                        <li>{{ $tag->name[Config::get('app.locale')] }} &nbsp; <a href="{{ route('admin.tags_edit',[
                            'locale' => app()->getLocale(),
                            'tags_id'=>$tag->id
                            ]) }}">
                                <i class="fa fa-edit"></i>
                            </a></li>
                        <ul>
                            @foreach ($tag->children as $child)
                            @include('admin.tags.child', ['child' => $child])
                            @endforeach
                        </ul>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection