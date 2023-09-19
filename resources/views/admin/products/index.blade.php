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
                <div class="card-header  text-white bg-dark ">{{ __('general.products.products') }}&nbsp;&nbsp;&nbsp;
                    <a class="btn btn-primary btn-sm" href="{{ route('admin.products_create',app()->getLocale()) }}">
                        <i class="fa fa-plus-square"></i> {{ __('general.add') }}
                    </a>
                </div>

                <div class="card-body">
                    <ul>
                        @foreach ($products as $prod)
                        <li><span>{{ $prod->partno }} &nbsp; {{ json_decode($prod->name,true)[Config::get('app.locale')]}} <a href="{{ route('admin.products_edit',[
                            'locale' => app()->getLocale(),
                            'products_id'=>$prod->id
                            ]) }}">
                                <i class="fa fa-edit"></i>
                            </a></span>

                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection