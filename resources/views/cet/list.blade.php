@extends('cet.base')

@section('title')
    成绩
@endsection

@section('css')
    <style>
        body {
            background: whitesmoke;
        }
        .admission {
            width: 92%;
            float: left;
            margin-left: 4%;
            margin-top: 20px;
        }
        .dj-button {
            display: block;
            width: 160px;
            margin: 20px auto;
        }
        tr td:first-child {
            text-align: right;
        }
        tr td:last-child {
            text-align: center;
        }
    </style>
@endsection

@section('body')
    <a href="{{ route('cet.add', ['mp' => $mp]) }}" class="dj-button pure-button pure-button-primary">登记准考证号</a>

    @for($i = 0; $i < count($admissions); $i ++)
        <table class="admission pure-table pure-table-bordered">
            @if($i === 0)
                <thead>
                <tr>
                    <td colspan="2">2015年下半年四六级考试</td>
                </tr>
                </thead>
            @endif
            <tbody>
            <tr>
                <td>姓名</td>
                <td>{{ $admissions[$i]->name }}</td>
            </tr>
            <tr>
                <td>准考证号</td>
                <td>{{ $admissions[$i]->number }}</td>
            </tr>
            @if($admissions[$i]->getScore() != null)
                <tr>
                    <td>听力</td>
                    <td>{{ $admissions[$i]->score->listen }}</td>
                </tr>
                <tr>
                    <td>阅读</td>
                    <td>{{ $admissions[$i]->score->read }}</td>
                </tr>
                <tr>
                    <td>写作和翻译</td>
                    <td>{{ $admissions[$i]->score->write }}</td>
                </tr>
                <tr>
                    <td>总分</td>
                    <td>{{ $admissions[$i]->score->total }}</td>
                </tr>
            @else
                <tr>
                    <td colspan="2">
                        <span>准考证信息有误，请修改。</span>
                        <br>
                        <a href="{{ route('cet.edit', ['admission' => $admissions[$i]->id, 'mp' => $mp]) }}" class="pure-button button-success">编辑</a>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="{{ route('cet.delete', ['admission' => $admissions[$i]->id, 'mp' => $mp]) }}" class="pure-button button-error">删除</a>
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    @endfor
@endsection