@extends('layouts.admin')

@section('content')

<div class="container" ng-controller="ProductCtrl">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{#message#}{{ (isset($product)) ? __('general.edit') : __('general.add') }} {{ __('general.products.name') }}</div>

                <div class="card-body">
                    <form name="add-product-form" id="add-product-form" method="post" action="{{ route('admin.products_store',app()->getLocale()) }}">
                        @csrf
                        <div class="container">
                            <div class="row">
                                <div class="col-8">
                                    <div class="card">
                                        <div class="card-header"> {{__('general.details')}}
                                        </div>
                                        <div class="card-body">@include('admin.products.tab_lang')</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row">
                                        <div class="card">
                                            <div class="card-header">
                                                {{__('general.category.category')}}
                                            </div>
                                            <div class="card-body">
                                                <div class="form-check" ng-repeat="category in listsOptions.category">
                                                    <input class="form-check-input" type="checkbox" ng-model="category.selected" value="category.name">
                                                    <label class="form-check-label" for="flexCheckDefault">{#category.name[lang]#} </label>
                                                </div>
                                                <a class="btn btn-sm" ng-click="check()">Check</a>

                                                <!--select size="10" name="category[]" ng-model="frmCreateProduct.category" multiple>
                                        <option ng-repeat="option in listsOptions.category" ng-value="option.id">{#option.name[lang]#}</option>
                                    </select-->
                                                <pre>Select = {#selectedCategory | json#}</pre>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="card">
                                            <div class="card-header">
                                                {{__('general.keywords.keywords')}}
                                            </div>
                                            <div class="card-body">
                                                <div class="form-check" ng-repeat="keyword in listsOptions.keywords">
                                                    <input class="form-check-input" type="checkbox" ng-model="keyword.selected" value="keyword.name">
                                                    <label class="form-check-label" for="flexCheckDefault">{#keyword.name[lang]#} </label>
                                                </div>
                                                <a class="btn btn-sm" ng-click="check()">Check</a>

                                                <!--select size="10" name="category[]" ng-model="frmCreateProduct.category" multiple>
                                        <option ng-repeat="option in listsOptions.category" ng-value="option.id">{#option.name[lang]#}</option>
                                    </select-->
                                                <pre>Select = {#selectedKeywords  | json#}</pre>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="card">
                                            <div class="card-header">
                                                {{__('general.tags.tags')}}
                                            </div>
                                            <div class="card-body">
                                                <div class="form-check" ng-repeat="tag in listsOptions.tags">
                                                    <input class="form-check-input" type="checkbox" ng-model="tag.selected" value="tag.name">
                                                    <label class="form-check-label" for="flexCheckDefault">{#tag.name[lang]#} </label>
                                                </div>
                                                <a class="btn btn-sm" ng-click="check()">Check</a>

                                                <!--select size="10" name="category[]" ng-model="frmCreateProduct.category" multiple>
                                        <option ng-repeat="option in listsOptions.category" ng-value="option.id">{#option.name[lang]#}</option>
                                    </select-->
                                                <pre>Select = {#selectedTags | json#}</pre>
                                            </div>
                                        </div>

                                    </div>


                                    <div class="row">
                                        <div class="card">
                                            <div class="card-header">
                                                {{__('general.products.products')}}
                                            </div>
                                            <div class="card-body">
                                                <div class="row"><label for="product_code">{{__('general.products.code')}}</label>
                                                    <input type="text" id="seq" class="form-control" placeholder="01" name="product_code">
                                                </div>
                                                <div class="row"><label for="parent_product">{{ __('general.products.parent_product') }}</label>
                                                    <div class="form-check" ng-repeat="product in productList">
                                                            <input class="form-check-input" type="checkbox" ng-model="product.selected" value="product.id">
                                                            <label class="form-check-label" for="flexCheckDefault">{#product.name[lang]#} </label>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row"><label for="parent_product">{{ __('general.products.parent_product') }}</label></div>
                                        <div class="row"><label for="web_available">{{ __('general.products.web_available') }}</label></div>
                                        <div class="row"><label for="web_settings">{{ __('general.products.web_settings') }}</label></div>
                                        <div class="row">
                                            <label for="seq">{{__('general.seq')}}</label>
                                            <input type="text" id="seq" class="form-control" placeholder="01" name="seq">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <label for="seq">{{__('general.keywords.keywords')}}</label>
                                </div>

                            </div>
                            <br>
                            <div class="form-group">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">{{__('general.add')}}</button>
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
<script>
    CKEDITOR.config.height = 150;
    CKEDITOR.config.width = 'auto';
</script>
@foreach (Config::get('app.locales') as $locale)
<script>
    CKEDITOR.replace('editor-intro-{{$locale}}');
    CKEDITOR.replace('editor-content-{{$locale}}');
    CKEDITOR.replace('editor-spec-{{$locale}}');
</script>
@endforeach
@endsection