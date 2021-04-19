<?php

namespace addons\spider\library;

use think\Db;

class Spider
{

    public $config = [];
    public $bot    = '';
    public $agent  = '';

    public function __construct()
    {
        $this->config = get_addon_config('spider');

    }

    public function get_spider($agent)
    {
        $this->agent = $agent;
        foreach ($this->config['spider'] as $key => $value) {
            $key = strtolower($key);
            if (strpos($this->agent, $key) !== false) {
                $this->bot = $value;
                break;
            }
        }
        return $this->bot;
    }

    public function save_log($title)
    {
        Db::name('spider')->insert([
            'spider'      => $this->bot,
            'title'       => $title,
            'url'         => request()->baseUrl(true),
            'ismobile'    => request()->isMobile() ? 1 : 0,
            'agent'       => $this->agent,
            'create_time' => time(),
            'ip'          => request()->ip(),
        ]);

    }
}
