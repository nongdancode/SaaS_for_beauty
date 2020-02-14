window.addEntity = (name, entity) => {
    window.entities = {
        ...(window.entities || {}),
        [name]: entity
    };
};

angular.module('app.third-party', [
    'ng-admin',
    'ui.calendar',
    'ngStorage'
]);

angular.module('app.resources', []);

angular.module('app.services', [
    'service.utility',
    'service.user',
    'service.auth'
]);

angular.module('app.directives', [
    'directive.draggable'
]);

angular.module('app.modules', [
    'module.user',
    'module.calendar'
]);

angular.module('app', [
    'app.third-party',
    'app.resources',
    'app.services',
    'app.directives',
    'app.run',
    'app.modules',
    'app.config'
]);
