/**
 * Created by nicholas on 16-3-28.
 */
(function () {
    'use strict';

    angular
        .module('app.login')
        .controller('LoginController', LoginController);

    LoginController.$inject = ['$http', '$state'];

    function LoginController($http, $state) {
        var vm = this;

        vm.login = login;

        function login(user) {
            $http.post('/auth/login', user).success(function () {
                $state.go('dashboard');
            });
        }
    }
}());