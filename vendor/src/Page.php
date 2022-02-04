<?php

namespace CMSLite;
use Rain\Tpl;
use CMSLite\Translate;
use CMSLite\Statistics;

class Page{
    private $tpl;

    public function __construct(){
        global $header;

        $config = array(
            "tpl_dir" => TPL_DIR,
            "cache_dir" => TPL_CACHE
        );

        $translate = [
            "text" => new Translate()
        ];

        $header = array_merge($header, $translate);

        Tpl::configure($config);
        $this->tpl = new Tpl;
        $this->setTpl('header', $header);
    }

    public function setData($data = array()){
        foreach ($data as $key => $value) {
            $this->tpl->assign($key, $value);
        }
    }

    public function setTpl($tplName, $params = array()){
        $this->setData($params);
        return $this->tpl->draw($tplName);
    }

    public function __destruct(){
        global $footer;

        $footer = array_merge($footer, Statistics::getStatistics());

        $this->setTpl('footer', $footer);
    }
}