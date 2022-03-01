<?php

namespace CMSLite;
use Rain\Tpl;
use CMSLite\Translate;
use CMSLite\Statistics;

class Page{
    private $tpl;

    public function __construct(){

        $config = array(
            "tpl_dir" => TPL_DIR,
            "cache_dir" => TPL_CACHE
        );

        $translate = [
            "text" => new Translate()
        ];

        Tpl::configure($config);
        $this->tpl = new Tpl;
        $this->setTpl('header', $translate);
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