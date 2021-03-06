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
            $http.get('/api/wx3rd/mp/' + $stateParams.mp + '/info').success(function (data) {
                vm.mp = data;
            });
        }
    }
}());