var app = angular.module('akasa-web', ['ngMessages','ngSanitize']
    , ['$httpProvider', function ($httpProvider) {
        $httpProvider.defaults.headers.post['X-CSRF-TOKEN'] = $('meta[name=csrf-token]').attr('content');
        $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8;';
    }]);
    
    app.config(function($interpolateProvider) {
        // To prevent the conflict of `{{` and `}}` symbols
        // between Blade template engine and AngularJS templating we need
        // to use different symbols for AngularJS.
    
        $interpolateProvider.startSymbol('{#');
        $interpolateProvider.endSymbol('#}');
      });   