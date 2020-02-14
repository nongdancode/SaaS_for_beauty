(function () {
    angular.module('module.user', [])
        .config(function (NgAdminConfigurationProvider) {
            const nga = NgAdminConfigurationProvider;

            const user = nga.entity('users');

            user.listView().fields([
                nga.field('name'),
                nga.field('username'),
                nga.field('email')
            ]);

            window.addEntity('user', user);
        });
})();
