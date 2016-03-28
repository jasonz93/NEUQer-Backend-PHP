@include('wx3rd.layouts.header')

<div id="wrapper">

    <!-- Sidebar -->
    <div class="ui visible sidebar inverted vertical menu">
        <a class="item" ui-sref="dashboard">总览</a>
        <a class="item" ui-sref="mpinfo">公众号信息</a>
        <a class="item" ui-sref="reply">自动回复设置</a>
    </div><!-- / sidebar -->

    <!-- page wrapper for angular views-->
    <div id="page-wrapper">

        <!-- Angular views -->
        <div ui-view id="ui-view"></div>

    </div>

</div>

@include('wx3rd.layouts.footer')