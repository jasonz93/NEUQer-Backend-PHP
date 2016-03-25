@extends('wx3rd.manage.base')

@section('title')
    自动回复
@endsection

@section('body')
    <h1 class="ui dividing header">自动回复设置</h1>
    <a id="btnAdd" class="ui positive button">添加</a>
    <div class="ui grid">
        <div class="eight wide column">
            <h3>正在使用</h3>
            <div class="ui one cards" id="using"></div>
        </div>
        <div class="eight wide column">
            <h3>闲置</h3>
            <div class="ui one cards" id="free"></div>
        </div>
    </div>

    <div class="ui modal">
        <div class="header">添加自动回复</div>
        <div class="content">
            <div>
                <select class="ui dropdown" id="handlerName">
                    <option value="TURING">小纽扣</option>
                    <option value="KEYWORD">关键词回复</option>
                </select>
            </div>
            <div>
                <div class="ui input">
                    <input id="handlerPriority" type="number" placeholder="优先级（大于等于0）">
                </div>
            </div>
            <div id="handlerParams" class="ui form">
            </div>
        </div>
        <div class="footer">
            <a id="btnSave" class="ui positive button">保存</a>
        </div>
    </div>
@endsection

@section('javascripts')
    <script>
        $('.ui.checkbox').checkbox();

        function generateCardWithName(handler) {
            var card = $('<div>').addClass('card');
            $('<div>').addClass('content').append(
                    $('<div>').addClass('header').text(getFriendlyName(handler.name))
                            .append($('<span class="floating ui grey circular label">').text(handler.priority))
            ).appendTo(card);
            return card;
        }

        function generateTuringCard(handler) {
            var card = generateCardWithName(handler);
            var priorityInput = $('<input type="number">');
            var save = function () {
                var url = '{{ route('wx3rd.mp.manage.reply.handler.update', ['mp' => $mp->app_id, 'eventHandler' => 'HANDLER']) }}';
                $.ajax({
                    url: url.replace(/HANDLER/, handler.id),
                    type: 'put',
                    data: JSON.stringify({
                        priority: priorityInput.val()
                    }),
                    contentType: 'application/json',
                    success: function () {
                        refresh();
                    }
                });
            };
            $('<div class="content">')
                    .append(
                            $('<div class="ui labeled input">').append(
                                    $('<div class="ui label">').text('优先级')
                            ).append(priorityInput)
                    ).appendTo(card);
            $('<div class="content">')
                    .append(
                            $('<a class="ui primary button">').text('保存').click(save)
                    ).appendTo(card);
            return card;
        }

        function generateHandlerCard(handler) {
            switch (handler.name) {
                case 'TURING':
                    return generateTuringCard(handler);
                default:
                    return null;
            }
        }

        function refresh() {
            $('#using').empty();
            $('#free').empty();
            $.ajax({
                url: '{{ route('wx3rd.mp.manage.reply.handlers', ['mp' => $mp->app_id]) }}',
                success: function (handlers) {
                    $.each(handlers, function (index, handler) {
                        var card = generateHandlerCard(handler);
                        if (card === null)
                                return;
                        if (handler.priority == 0) {
                            card.appendTo($('#free'));
                        } else {
                            card.appendTo($('#using'));
                        }
                    });
                }
            });
        }

        refresh();

        $('#btnAdd').click(function () {
            $('.ui.modal').modal('show');
        });

        $('#handlerName').change(function () {
            var params = $('#handlerParams');
            switch ($('#handlerName').val()) {
                case 'KEYWORD':
                    $('<input type="text" name="keyword" placeholder="关键词">').appendTo(params);
                    $('<div class="inline field">')
                            .html('<div class="ui checkbox">' +
                                    '<input type="checkbox" name="accurate" tabindex="0">' +
                                    '<label>精确匹配</label>' +
                                    '</div>')
                            .appendTo(params);
                    break;
                default:
                    params.empty();
            }
        });

        $('#btnSave').click(function () {
            var params = [];
            $('#handlerParams input').each(function () {
                var item = $(this);
                var value;
                if (item.attr('type') == 'checkbox')
                    value = item.is(':checked');
                else
                    value = item.val();
                var name = item.attr('name');
                params[name] = value;
            });
            console.log(params);
            $.ajax({
                url: '{{ route('wx3rd.mp.manage.reply.handler.create', ['mp' => $mp->app_id]) }}',
                method: 'post',
                contentType: 'application/json',
                data: JSON.stringify({
                    name: $('#handlerName').val(),
                    priority: $('#handlerPriority').val(),
                    params: params
                }),
                success: function () {
                    $('.ui.modal').modal('hide');
                    refresh();
                }
            });
        });

        function getFriendlyName(name) {
            switch (name) {
                case 'TURING':
                    return '小纽扣';
                default:
                    return name;
            }
        }
    </script>
@endsection