(function(){
    angular.module('directive.draggable', [])
        .directive('draggable', function($interpolate) {
            return {
                restrict: 'A',
                link: function(scope, element, attr){
                    $(element).data('event', {
                        id: +attr.id,
                        title: $interpolate($.trim($(element).text()))(scope),
                        stick: true
                    });

                    $(element).draggable({
                        zIndex: 999,
                        revert: true,
                        revertDuration: 0
                    });
                }
            };
        });
})();
