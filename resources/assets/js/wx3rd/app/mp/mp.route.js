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
                state: 'mp',
                config: {
                    url: '/mp/:mp',
                    templateUrl: '/views/wx3rd/manage/mp',
                    controller: 'MPController',
                    controllerAs: 'vm',
                    title: 'MP'
                }
            }
        ];
    }
})();