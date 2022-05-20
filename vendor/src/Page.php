<?php

namespace CMSLite;
use Rain\Tpl;
use CMSLite\Translate;
use CMSLite\Statistics;

class Page{
    private $tpl;
    private $options = [
        "header" => true,
        "footer" => true
    ];

    public function __construct($opts = array()){

        $config = array(
            "tpl_dir" => TPL_DIR,
            "cache_dir" => TPL_CACHE
        );

        $translate = [
            "text" => new Translate()
        ];

        Tpl::configure($config);
        $this->tpl = new Tpl;

        $this->options = array_merge($this->options, $opts);

        if($this->options['header'] === true){
            $this->setTpl('header', $translate);
        }
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

        if($this->options['footer'] === true){
            $footer = array_merge($footer, Statistics::getStatistics());
            $this->setTpl('footer', $footer);
        }
    }
}