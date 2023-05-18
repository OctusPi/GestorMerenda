<?php
namespace Octus\App\Controller\Components;
use Octus\App\Model\EntityUsuario;
use Octus\App\Utils\View;

class NavBuilder
{

    public static function build(?EntityUsuario $user):string
    {
        if($user != null)
        {
            $userstruct = $user->buildnav();
            $navstruct  = self::navstruct();
            $tabs       = [];

            foreach ($userstruct as $ustruct) {
                if(is_array($ustruct))
                {
                    $navtabs = [];
                    foreach ($ustruct as $nav) {
                        if(key_exists($nav, $navstruct))
                        {
                            $navtabs[] = $navstruct[$nav];
                        }
                    }
                    $tabs[] = $navtabs;
                }
            }
            return self::nav($tabs);

        }else{
            return '';
        }
        
    }

    private static function nav(array $tabs):string
    {
        //initialize var nav root
        $nav = '';

        //loop nav root capture navsubitens
        foreach ($tabs as $key => $tab) {
            //initializa var subitens
            $itens = '';
            
            //loop renderize subitens
            foreach ($tab as $item) {
                $itens .= View::renderView('components/navitem', $item);
            }

            //checks if subites is not null and renderize nav tab root
            if($itens != null)
            {
                $params = ['color' => self::navcolors(strval($key)), 'itens' => $itens];
                $nav .= View::renderView('components/nav', $params);
            }
        }
        return $nav;
    }

    private static function navcolors(string $key):string
    {
        return match($key)
        {
            '0' => 'color-purple',
            '1' => 'color-blue',
            '2' => 'color-magenta',
            '3' => 'color-green',
            default => 'color-secondary'
        };
    }

    private static function navstruct():array
    {
        return [
            'producao' => [
                'name' => 'Produção Diária',
                'desc' => 'Registro Diário de Produção',
                'icon' => 'journal-richtext',
                'url'  => 'app?producao'
            ],
            'secretarias' => [
                'name' => 'Secretarias',
                'desc' => 'Unidades Ordenadoras',
                'icon' => 'houses',
                'url'  => '?app=secretarias'
            ],
            'departamentos' => [
                'name' => 'Departamentos',
                'desc' => 'Unidades Executoras',
                'icon' => 'inboxes',
                'url'  => '?app=departamentos'
            ],
            'calendario' => [
                'name' => 'Calendário Letivo',
                'desc' => 'Gestão de Datas e Dias Letivos',
                'icon' => 'calendar2-event',
                'url'  => '?app=calendario'
            ],
            'insumos' => [
                'name' => 'Insumos',
                'desc' => 'Gestão de Insumos Base',
                'icon' => 'boxes',
                'url'  => '?app=insumos'
            ],
            'estoque' => [
                'name' => 'Estoque',
                'desc' => 'Controle de Estoque',
                'icon' => 'box-seam',
                'url'  => '?app=estoque'
            ],
            'entradas' => [
                'name' => 'Entradas',
                'desc' => 'Registro de Entradas no Estoque',
                'icon' => 'clipboard2-plus',
                'url'  => '?app=entradas'
            ],
            'saidas' => [
                'name' => 'Saídas',
                'desc' => 'Registro de Saídas no Estoque',
                'icon' => 'clipboard2-minus',
                'url'  => '?app=saidas'
            ],
            'relatorios' => [
                'name' => 'Relatórios',
                'desc' => 'Dados Análitos e Quantitativos',
                'icon' => 'bar-chart',
                'url'  => '?app=reports'
            ]
        ];
    }
}