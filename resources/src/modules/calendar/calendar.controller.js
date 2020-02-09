(function(){
    angular.module('module.calendar.controller', [])
        .controller('CalendarController', CalendarController);

    function CalendarController($scope, $timeout, $state, $http) {
        $scope.eventSources = [];

        $scope.services = [
            { id: 1, name: 'Service 1' },
            { id: 2, name: 'Service 2' },
            { id: 3, name: 'Service 3' }
        ];

        $scope.uiConfig = {
            calendar: {
                editable: true,
                droppable: true,
                drop: function() {
                    const id = +this.getAttribute('data-id');
                    const serviceIndex = $scope.services.findIndex(service => service.id === id);

                    $scope.services.splice(serviceIndex, 1);
                    $(this).remove();
                },
                eventRender: function(event, element) {
                    element.html(event.title + '<span style="font-size: 12px;" class="removeEvent glyphicon glyphicon-trash pull-right" id="Delete"></span>');
                },
                eventClick: function(calEvent, jsEvent, view) {
                    if (jsEvent.target.id === 'Delete') {
                        $scope.services.push({ id: calEvent.id, name: calEvent.title });
                        $('.calendar').fullCalendar('removeEvents', $(this).data('id'));
                    }
                },
                header:{
                    left: 'month agendaWeek agendaDay',
                    center: 'title',
                    right: 'today prev,next'
                }
            }
        };
    }
})();
