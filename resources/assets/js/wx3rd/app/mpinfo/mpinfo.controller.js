/**
 * Created by nicholas on 16-3-29.
 */
(function () {
    'use strict';

    angular
        .module('app.mpinfo')
        .controller('MPInfoController', MPInfoController);

    MPInfoController.$inject = ['$http', '$stateParams'];

    function MPInfoController($http, $stateParams) {
        var vm = this;

        vm.refresh = refresh;

        getData();

        function getData() {
            $http.get('/api/wx3rd/mp/' + $stateParams.mp + '/info').success(function (data) {
                vm.mp = data;
            });
        }

        function refresh() {
            $http.get('/api/wx3rd/mp/' + $stateParams.mp + '/refresh').success(function () {
                getData();
            });
        }
    }
}());