(function () {
    angular.module('service.user', [])
        .factory('UserService', UserService);

    function UserService($localStorage) {
        $localStorage.globals = $localStorage.globals || {};
        var service = {};

        service.setCurrentUser = function (user) {
            $localStorage.globals.currentUser = user;
        };

        service.getCurrentUser = function () {
            return $localStorage.globals.currentUser;
        };

        service.isLoggedIn = function () {
            return $localStorage.globals.currentUser ? true : false;
        };

        return service;
    }
})();
