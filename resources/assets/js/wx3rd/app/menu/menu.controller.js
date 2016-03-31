/**
 * Created by nicholas on 16-3-30.
 */
(function () {
    'use strict';

    angular
        .module('app.menu')
        .controller('MenuController', MenuController);

    MenuController.$inject = ['$http', '$stateParams'];

    function MenuController($http, $stateParams) {
        var vm = this;

        vm.current = {
            button: []
        };

        getData();

        function getData() {
            $http.get('/api/wx3rd/mp/' + $stateParams.mp + '/menu/current').success(function (data) {
                vm.current = data;
            });
        }

        vm.setCurrentItem = function (item) {
            vm.currentItem = item;
        };

        vm.save = function (menu) {
            $http.post('/api/wx3rd/mp/' + $stateParams.mp + '/menu', menu).success(function () {
                getData();
            });
        };
    }
}());