/**
 * Created by nicholas on 16-3-28.
 */
(function() {

    'use strict';

    angular
        .module('app.shake')
        .run(appRun);

    appRun.$inject = ['routerHelper'];
    /* @ngInject */
    function appRun(routerHelper) {
        routerHelper.configureStates(getStates());
    }

    function getStates() {
        return [
            {
                state: 'mp.shake',
                config: {
                    url: '/shake',
                    templateUrl: '/views/wx3rd/manage/shake/index',
                    controller: 'ShakeController',
                    controllerAs: 'vm',
                    title: 'Shake'
                }
            }
        ];
    }
})();