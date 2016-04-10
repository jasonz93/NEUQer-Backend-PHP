<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-3-23
 * Time: 下午8:22
 */

namespace NEUQer\Services;


use Endroid\QrCode\QrCode;
use NEUQer\User;

class QrcodeService
{
    private $qrcode;

    const Size = 300;

    const Padding = 10;

    const ErrorCorrection = 'low';

    private $url;


    public function __construct(){
        $this->qrcode = new QrCode();
        $this->url = config('app.url');
    }

    public function setLabel($text, $font = 16){
        $this->qrcode->setLabel($text)
            ->setLabelFontSize($font);
    }

    public function generate($id, $uniqid){
        $url = $this->url."/public/wx3rd/qrcode/$id/check?uniqid=$uniqid";

        $image = $this->qrcode
            ->setText($url)
            ->setSize(self::Size)
            ->setPadding(self::Padding)
            ->setErrorCorrection(self::ErrorCorrection)
            ->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0, 'a' => 0])
            ->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255, 'a' => 0])
            ->getImage();
        return $image;
    }

}