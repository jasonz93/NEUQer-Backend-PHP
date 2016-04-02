/**
 * Created by nicholas on 16-3-28.
 */
(function () {
    'use strict';

    angular
        .module('app.dashboard')
        .controller('DashboardController', DashboardController);

    DashboardController.$inject = ['$http'];

    function DashboardController($http) {
        var vm = this;

        getData();

        function getData() {
            $http.get('/api/wx3rd/mps').success(function (data) {
                vm.mps = data;
            });
        }
    }
}());