/**
 * Created by nicholas on 16-3-29.
 */
(function () {
    'use strict';

    angular
        .module('app.mp')
        .controller('MPController', MPController);

    MPController.$inject = ['$http', '$stateParams'];

    function MPController($http, $stateParams) {
        var vm = this;

        getData();

        function getData() {
            $http.get('/api/wx3rd/mps').success(function (data) {
                vm.mps = data;
            });
        }
    }
}());