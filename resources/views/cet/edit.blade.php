@extends('cet.base')

@section('title')
    @if(isset($admission))
        修改准考证信息
    @else
        添加准考证信息
    @endif
@endsection

@section('css')
    <style>
        body {
            background: whitesmoke;
        }
        .zkz-form {
            width: 80%;
            margin: 20px 10%;
        }
    </style>
@endsection

@section('body')
    <form class="pure-form pure-form-stacked zkz-form" method="post">
        {!! csrf_field() !!}
        <fieldset>
            <legend>准考证信息</legend>

            <label for="number">准考证号</label>
            <input name="number" id="number" type="text" placeholder="15 位数字"@if(isset($admission)) value="{{ $admission->number }}"@endif>

            <label for="name">姓名</label>
            <input name="name" id="name" type="text" placeholder="输入姓名"@if(isset($admission)) value="{{ $admission->name }}"@endif>

            <button type="submit" class="pure-button pure-button-primary">保存</button>
        </fieldset>
    </form>
@endsection