/**
 * Created by nicholas on 16-3-28.
 */
(function() {

    'use strict';

    angular
        .module('app.dashboard')
        .run(appRun);

    appRun.$inject = ['routerHelper'];
    /* @ngInject */
    function appRun(routerHelper) {
        routerHelper.configureStates(getStates());
    }

    function getStates() {
        return [
            {
                state: 'dashboard',
                config: {
                    url: '/dashboard',
                    templateUrl: '/views/wx3rd/manage/dashboard/index',
                    controller: 'DashboardController',
                    controllerAs: 'vm',
                    title: 'Dashboard'
                }
            }
        ];
    }
})();