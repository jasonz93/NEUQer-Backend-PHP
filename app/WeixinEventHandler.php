<?php

namespace NEUQer;

use Illuminate\Database\Eloquent\Model;
use NEUQer\Weixin\EventHandlerInterface;
use NEUQer\Weixin\KeywordEventHandler;
use NEUQer\Weixin\TuringHandler;

class WeixinEventHandler extends Model
{
    protected $casts = [
        'params' => 'array'
    ];

    protected $handlers = [
        TuringHandler::NAME => TuringHandler::class,
        KeywordEventHandler::NAME => KeywordEventHandler::class
    ];

    public function mp() {
        return $this->belongsTo('NEUQer\Wx3rdMP', 'mp_app_id', 'app_id');
    }

    /**
     * @return EventHandlerInterface
     */
    public function getInstance() {
        $clazz = new \ReflectionClass($this->handlers[$this->name]);
        return $clazz->newInstance();
    }

    /**
     * @param WeixinUser $weixinUser
     * @param array $xml
     * @return array
     */
    public function handle(WeixinUser $weixinUser, array $xml) {
        $handler = $this->getInstance();
        $params = $this->params;
        return $handler->handle($weixinUser, $xml, $params);
    }
}
