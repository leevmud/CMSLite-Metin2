<?php
namespace CMSLite;

class Translate{

    public static function text($value){

        switch (SERVER_LANG) {
            case 'pt-br':
                $array = file_get_contents(APP_LANG.'pt-br.json');
                $array = json_decode($array, true);
                break;

            case 'en':
                $array = file_get_contents(APP_LANG.'en.json');
                $array = json_decode($array, true);
                break;
            
            default:
                $array = file_get_contents(APP_LANG.'pt-br.json');
                $array = json_decode($array, true);
                break;
        }

        if(!isset($array[$value])){
            return 
            'O texto para essa ação precisa ser adicionado.<br>
            The text for this actions need to be added.';
        }

        return $array[$value];
    }


    //Se desejar tornar o html dinâmico baseado no idioma:
    //Veja header.html -> {$text->textHTML('btn_home')}

    public function textHTML($value){
        switch (SERVER_LANG) {
            case 'pt-br':
                $array = file_get_contents(APP_LANG.'pt-br.json');
                $array = json_decode($array, true);
                break;

            case 'en':
                $array = file_get_contents(APP_LANG.'en.json');
                $array = json_decode($array, true);
                break;
            
            default:
                $array = file_get_contents(APP_LANG.'pt-br.json');
                $array = json_decode($array, true);
                break;
        }

        if(!isset($array[$value])){
            return 
            'O texto para essa ação precisa ser adicionado.<br>
            The text for this actions need to be added.';
        }

        return $array[$value];
    }
}