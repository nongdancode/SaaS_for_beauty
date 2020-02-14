(function() {
  angular
    .module('app.run', [])
    .run(authentication);

  function authentication($rootScope, $state, $location, UserService){
    $rootScope.$on('$stateChangeStart', function (event, next, current) {
      // if (!UserService.isLoggedIn() && current.name != 'settings.signin') {
      //   $location.path('/settings/signin');
      // }
    });
  };
})();
