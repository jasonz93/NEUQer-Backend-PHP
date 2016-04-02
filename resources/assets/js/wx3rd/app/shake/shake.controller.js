/**
 * Created by nicholas on 16-3-28.
 */
(function () {
    'use strict';

    angular
        .module('app.shake')
        .controller('ShakeController', ShakeController);

    ShakeController.$inject = ['$http', '$stateParams'];

    function ShakeController($http, $stateParams) {
        var vm = this;

        vm.getStatus = getStatus;

        getStatus();

        function getStatus() {
            $http.get('/api/wx3rd/mp/' + $stateParams.mp + '/shake/audit').success(function (data) {
                console.log(data);
                vm.audit = data.data;
            });
        }
    }
}());