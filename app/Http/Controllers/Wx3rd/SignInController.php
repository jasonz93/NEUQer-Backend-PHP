<?php
namespace NEUQer\Http\Controllers\Wx3rd;
use NEUQer\Http\Controllers\Controller;
use NEUQer\Services\QrcodeService;
use NEUQer\SigninAdmission;
use NEUQer\SigninQrcode;
use NEUQer\WeixinOAuth;
use NEUQer\WeixinUser;
use NEUQer\Wx3rdMP;
use Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Created by PhpStorm.
 * User: trons
 * Date: 16-4-4
 * Time: 下午2:54
 */
class SignInController extends Controller
{
    /**
     * @var QrcodeService
     */
    private $qrcodeService;

    /**
     * @var SigninAdmission
     */
    private $admission;

    public function __construct(QrcodeService $qrcodeService){
        $this->qrcodeService = $qrcodeService;
        $this->admission = SigninAdmission::whereUserId(\Auth::user()->id)->first();
    }

    public function index(Wx3rdMP $mp) {
        return view('signin.index');
    }

    public function getAdd(){
        return view('signin.index');
    }

    public function postAdd(Wx3rdMP $mp){
        if($this->admission == null){
            $admission = new SigninAdmission();
            $admission->user()->associate(\Auth::user());
            $admission->weixinUser()->associate(WeixinOAuth::getFromSession()->weixinUser);
            $admission->stu_id = Request::input('stu_id');
            $admission->name = Request::input('name');
            $admission->saveOrFail();
        }
        $this->admission->touch();
        return 1;

    }

    public function getInfo(Wx3rdMP $mp){
        return response()->json($this->admission);
    }

    public function getQrcode(Wx3rdMP $mp){
        $uniqid = uniqid();
        $signin = new SigninQrcode();
        $signin->addSignin($this->admission->id, $uniqid);
        $image = $this->qrcodeService->generate($this->admission->id, $uniqid);
        imagepng($image);
        return new Response('',200,['Content-Type'=>'image/png']);
    }

    public function getDelete(Wx3rdMP $mp){
        $this->admission->delete();
        return response()->json([
            'status' => 0
        ]);
    }

    public function check(Wx3rdMP $mp){
        $uniqid = Request::query('uniqid');
        $signin = new SigninQrcode();
        if($signin->checkSignin($this->admission->id, $uniqid)){
            return response()->json([
                'status' => 0
            ]);
        }
        return response()->json([
            'ststus' => '10000'
        ]);
    }
}