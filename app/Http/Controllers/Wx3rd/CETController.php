<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-3-9
 * Time: 下午3:07
 */

namespace NEUQer\Http\Controllers\Wx3rd;

use NEUQer\CETAdmission;
use NEUQer\Http\Controllers\Controller;
use NEUQer\WeixinOAuth;
use NEUQer\Wx3rdMP;
use Request;
use Gate;

class CETController extends Controller
{
    public function getList(Wx3rdMP $mp) {
        $admissions = CETAdmission::whereUserId(\Auth::user()->id)->get();
        return view('cet.list', ['admissions' => $admissions, 'mp' => $mp->app_id]);
    }

    public function getAdd() {
        return view('cet.edit');
    }

    public function postAdd(Wx3rdMP $mp) {
        $admission = new CETAdmission();
        $admission->user()->associate(\Auth::user());
        $admission->weixinUser()->associate(WeixinOAuth::getFromSession()->weixinUser);
        $admission->setNumber(Request::input('number'));
        $admission->name = Request::input('name');
        $admission->saveOrFail();
        return redirect(route('cet.list', ['mp' => $mp->app_id]));
    }

    public function getEdit(Wx3rdMP $mp, CETAdmission $admission) {
        abort_if(Gate::denies('owns', $admission), 403);
        return view('cet.edit', ['admission' => $admission]);
    }

    public function postEdit(Wx3rdMP $mp, CETAdmission $admission) {
        abort_if(Gate::denies('owns', $admission), 403);
        $admission->setNumber(Request::input('number'));
        $admission->name = Request::input('name');
        $admission->saveOrFail();
        return redirect(route('cet.list', ['mp' => $mp->app_id]));
    }

    public function getDelete(Wx3rdMP $mp, CETAdmission $admission) {
        abort_if(Gate::denies('owns', $admission), 403);
        $admission->delete();
        return redirect(route('cet.list', ['mp' => $mp->app_id]));
    }
}