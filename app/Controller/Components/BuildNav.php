<?php
namespace Octus\App\Controller\Components;
use Octus\App\Model\EntityUsuario;

class BuildNav
{
    public static function build(EntityUsuario $user):string
    {
        $struct = $user->buildnav();

        return '';
    }

    private static function nav(array $itens):string
    {
        return '';
    }

    private static function navdrop(?array $params):string
    {
        return '';
    } 

    private static function navitem(array $params):string
    {
        return '';
    }

    private static function navsubitem($params):string
    {
        return '';
    }
}