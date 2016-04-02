/**
 * Created by nicholas on 16-3-28.
 */
(function() {

    'use strict';

    angular
        .module('app.login')
        .run(appRun);

    appRun.$inject = ['routerHelper'];
    /* @ngInject */
    function appRun(routerHelper) {
        routerHelper.configureStates(getStates());
    }

    function getStates() {
        return [
            {
                state: 'login',
                config: {
                    url: '/login',
                    templateUrl: '/views/wx3rd/manage/login/login',
                    controller: 'LoginController',
                    controllerAs: 'vm',
                    title: 'Login'
                }
            }
        ];
    }
})();