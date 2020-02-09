(function(){
    angular.module('module.calendar.route', [
    ]).config(CalendarConfig);

    function CalendarConfig($stateProvider) {
        $stateProvider
            .state('calendar', {
                parent: 'ng-admin',
	        url: '/calendar',
	        controller: 'CalendarController',
	        templateUrl: 'src/modules/calendar/calendar.html',
                cache: false
            });
    };
})();
