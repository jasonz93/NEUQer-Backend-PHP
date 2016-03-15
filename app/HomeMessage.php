<?php

namespace NEUQer;

use Illuminate\Database\Eloquent\Model;

class HomeMessage extends Model
{
    protected $fillable = [
        'banner',
        'icon',
        'title',
        'subtitle',
        'type',
        'param',
        'is_banner',
        'position',
        'show'
    ];

    public static function getBanners($parse = true) {
        $banners = self::whereIsBanner(true)
            ->where('position', '>', 0)
            ->orderBy('position')
            ->get();
        if ($parse) {
            $result = [];
            foreach ($banners as $banner) {
                $result[] = $banner->toBanner();
            }
            return $result;
        } else {
            return $banners;
        }
    }

    public static function getLists($parse = true) {
        $lists = self::where('position', '>', 0)
            ->orderBy('position')
            ->get();
        if ($parse) {
            $result = [];
            foreach ($lists as $list) {
                $result[] = $list->toList();
            }
            return $result;
        } else {
            return $lists;
        }
    }

    public static function getHistory($per, $page) {
        return self::where('position', '<=', 0)
            ->whereShow(true)
            ->orderBy('created_at', 'desc')
            ->limit($per)
            ->offset($per * ($page - 1))
            ->get();
    }

    public function toBanner() {
        return [
            'image' => $this->banner,
            'title' => $this->title,
            'click' => $this->getClick()
        ];
    }

    public function toList() {
        return [
            'icon' => $this->icon,
            'title' => $this->title,
            'content' => $this->subtitle,
            'click' => $this->getClick()
        ];
    }

    public function toArray()
    {
        return [
            'banner' => $this->banner,
            'icon' => $this->icon,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'click' => $this->getClick(),
            'createTime' => strtotime($this->created_at) * 1000
        ];
    }

    public function getClick() {
        $click = [
            'type' => $this->type
        ];
        switch ($this->type) {
            case 'view':
                $click['url'] = $this->param;
                break;
            case 'bbs':
                $click['attr'] = [
                    'topicId' => $this->param
                ];
                break;
        }
        return $click;
    }
}
