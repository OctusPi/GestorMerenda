<?php
namespace Octus\App\Controller\Components;
use Octus\App\Utils\Route;
use Octus\App\Utils\View;

class ActionBuilder
{

    public static function build(array $actions, ?int $target):string
    {
        if($target != null)
        {
            $navstruct  = self::navstruct($target);
            $tabs       = [];

            foreach ($actions as $act) {
                if(key_exists($act, $navstruct)){
                    $tabs[] = $navstruct[$act];
                }
            }
            return self::nav($tabs);
        }else{
            return '';
        }
        
    }

    private static function nav(array $tabs):string
    { 
        //initializa var subitens and loop renderize subitens
        $itens = '';  
        foreach ($tabs as $item) {
            $itens .= View::renderView('components/tabactionitem', $item);
        }

        return View::renderView('components/tabaction', ['tab_action_itens' => $itens]);
    }

    private static function navstruct(?int $target):array
    {
        return [
            'edit' => [
                'name' => 'Editar',
                'desc' => 'Editar dados do registro',
                'icon' => 'bi-pencil',
                'url'  => '#',
                'attr' => 'data-edit="'.Route::route(['action' => 'json', 'key' => $target]).'"'
            ],
            'delete' => [
                'name' => 'Excluir',
                'desc' => 'Apagar registro do sistema',
                'icon' => 'bi-trash3',
                'url'  => '#',
                'attr' => 'data-bs-toggle="modal" data-bs-target="#modalDell" data-delet="'.$target.'"'
            ],
            'ficha' => [
                'name' => 'Ficha do Aluno',
                'desc' => 'Gerar documento em PDF',
                'icon' => 'bi-file-earmark-pdf',
                'url'  => Route::route(['action'=> 'export', 'key'=>$target]),
                'attr' => ''
            ],
            'matricula' => [
                'name' => 'Matrículas',
                'desc' => 'Visualizar Registros de Matrículas',
                'icon' => 'bi-file-earmark-richtext',
                'url'  => Route::route(['app'=> 'matriculas', 'action'=>'start', 'key'=>$target]),
                'attr' => ''
            ],
            'boletim' => [
                'name' => 'Boletim',
                'desc' => 'Visualizar Registros de Notas',
                'icon' => 'bi-file-earmark-richtext',
                'url'  => Route::route(['app'=> 'boletim', 'action'=>'start', 'key'=>$target]),
                'attr' => ''
            ],
            'alunos' => [
                'name' => 'Listar Alunos',
                'desc' => 'Imprmir Lista de Alunos na Turma',
                'icon' => 'bi-file-earmark-pdf',
                'url'  => Route::route(['app'=> 'alunos', 'action'=>'export', 'key'=>$target]),
                'attr' => ''
            ],
            'comprovante' => [
                'name' => 'Comprovante',
                'desc' => 'Comprovante de Matrícula',
                'icon' => 'bi-bookmark-star',
                'url'  => Route::route(['app'=> 'matriculas', 'action'=>'export', 'type'=>'receipt', 'key'=>$target]),
                'attr' => ''
            ]
        ];
    }
}