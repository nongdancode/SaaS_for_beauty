(function(){
  angular
    .module('service.auth', [])
    .factory('AuthService', AuthService)
    .factory('AuthInterceptor', AuthInterceptor);

  function AuthService($http, $q) {
    var service = {};

    service.login = function(email, password) {};

    service.logout = function() {};

    return service;
  }

  function AuthInterceptor($location) {
    var service = {};

    service.request = function(config) {
      return config;
    };

    service.responseError = function(response) {
      if(response.status === 401) {
	$location.path('/admin/login');
      }
      return response;
    };
    return service;
  }
})();
