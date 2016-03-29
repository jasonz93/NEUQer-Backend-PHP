/**
 * Created by nicholas on 16-3-29.
 */
(function() {

    'use strict';

    angular
        .module('app.mpinfo')
        .run(appRun);

    appRun.$inject = ['routerHelper'];
    /* @ngInject */
    function appRun(routerHelper) {
        routerHelper.configureStates(getStates());
    }

    function getStates() {
        return [
            {
                state: 'mp.info',
                config: {
                    url: '/info',
                    templateUrl: '/views/wx3rd/manage/mpinfo/index',
                    controller: 'MPInfoController',
                    controllerAs: 'vm',
                    title: 'MPInfo'
                }
            }
        ];
    }
})();