/**
 * Created by nicholas on 16-3-29.
 */
(function () {
    'use strict';

    angular
        .module('app.reply')
        .controller('ReplyController', ReplyController);

    ReplyController.$inject = ['$http', '$stateParams'];

    function ReplyController($http, $stateParams) {
        var vm = this;
        vm.save = save;
        vm.showAdd = showAdd;
        vm.create = create;

        getData();

        function getData() {
            vm.free = [];
            vm.using = [];
            $http.get('/api/wx3rd/mp/' + $stateParams.mp + '/reply/handlers').success(function (handlers) {
                for (var i in handlers) {
                    if (handlers[i].priority == 0) {
                        vm.free.push(handlers[i]);
                    } else {
                        vm.using.push(handlers[i]);
                    }
                }
            });
        }

        function save(handler) {
            $http.put('/api/wx3rd/mp/' + $stateParams.mp + '/reply/handler/' + handler.id, handler).success(function () {
                getData();
            });
        }

        function create(handler) {
            $http.post('/api/wx3rd/mp/' + $stateParams.mp + '/reply/handler', handler).success(function () {
                getData();
            });
        }

        function showAdd() {
            console.log('try to show add modal');
            vm.showAddModal = true;
        }
    }
}());