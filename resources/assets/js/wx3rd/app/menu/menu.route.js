/**
 * Created by nicholas on 16-3-30.
 */
(function() {

    'use strict';

    angular
        .module('app.menu')
        .run(appRun);

    appRun.$inject = ['routerHelper'];
    /* @ngInject */
    function appRun(routerHelper) {
        routerHelper.configureStates(getStates());
    }

    function getStates() {
        return [
            {
                state: 'mp.menu',
                config: {
                    url: '/menu',
                    templateUrl: '/views/wx3rd/manage/menu/index',
                    controller: 'MenuController',
                    controllerAs: 'vm',
                    title: 'Menu'
                }
            }
        ];
    }
})();