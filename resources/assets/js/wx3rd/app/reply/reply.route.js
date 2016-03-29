/**
 * Created by nicholas on 16-3-29.
 */
(function() {

    'use strict';

    angular
        .module('app.reply')
        .run(appRun);

    appRun.$inject = ['routerHelper'];
    /* @ngInject */
    function appRun(routerHelper) {
        routerHelper.configureStates(getStates());
    }

    function getStates() {
        return [
            {
                state: 'mp.reply',
                config: {
                    url: '/reply',
                    templateUrl: '/views/wx3rd/manage/reply/index',
                    controller: 'ReplyController',
                    controllerAs: 'vm',
                    title: 'Reply'
                }
            }
        ];
    }
})();