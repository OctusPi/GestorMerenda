<?php
namespace Octus\App\Controller\Components;
use Octus\App\Model\EntityUsuario;
use Octus\App\Utils\Utils;
use Octus\App\Utils\View;

class BuildNav
{
    public static function build(EntityUsuario $user):string
    {
        $userstruct = $user->buildnav();
        $navstruct  = self::navstruct();
        $itens   = [];

        foreach ($userstruct as $key => $item) {
            if(key_exists($key, $navstruct)){
                $itens[$key] = $navstruct[$key];
                if($item != null && is_array($item)){
                    $multitens = [];
                    foreach ($item as $i) {
                        if(key_exists($i, $navstruct[$key]['mult'])){
                            $multitens[$i] = $navstruct[$key]['mult'][$i];
                        }
                    }
                    $itens[$key]['mult'] = $multitens;
                }else{
                    $itens[$key]['mult'] = null;
                }
            }
        }

        return self::nav($itens);
    }

    private static function nav(array $itens):string
    {
        $nav = '';
        foreach ($itens as $item) {
            if(Utils::at('mult', $item) != null){
                $nav .= self::navdrop($item);
            }else{
                $nav .= self::navitem($item);
            }
        }
        return '';
    }

    private static function navitem(array $item):string
    {
        return View::renderView('components/navitem', $item);
    }

    private static function navdrop(?array $item):string
    {
        $subitens = '';
        foreach ($item['mult'] as $subitem) {
            $subitens .= self::navsubitem($subitem);
        }

        $item['subitens'] = $subitens;

        return View::renderView('components/navdrop', $item);
    } 

    private static function navsubitem($subitem):string
    {
        return View::renderView('components/subitem', $subitem);
    }

    private static function navstruct():array
    {
        return [];
    }
}