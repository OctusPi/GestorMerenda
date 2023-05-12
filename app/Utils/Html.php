<?php
namespace Octus\App\Utils;

use Octus\App\Utils\View;
use Octus\App\Utils\Route;

class Html
{
    /**
     * Render a paragraph with normal size font
     *
     * @param string|null $text
     * @param string|null $color
     * @return string
     */
    public static function pbig(?string $text, ?string $color = null):string
    {
        return '<p class="ocp-semi-bold cc-contrast '.$color.'">'.$text.'</p>';
    }

    /**
     * Render a small paragraph elative to normal font size
     *
     * @param string|null $text
     * @param string|null $color
     * @return string
     */
    public static function psmall(?string $text, ?string $color = 'text-dark'):string
    {
        return '<p class="small '.$color.'">'.$text.'</p>';
    }

    public static function pdef(?string $text = null, ?string $color = 'text-muted'):string
    {
        $text = $text != null ? $text : 'Aplique o filtro para visualizar os registros...';
        $icon = '<i class="bi-funnel-fill me-1"></i>';

        return '<p class="small text-center '.$color.'">'.$icon.$text.'</p>';
    }

    public static function amsg(?string $text, string $url = '#', string $color = 'text-success-dark'):string
    {
        return '<a href="'.$url.'" target="_blank" class="'.$color.'"><strong>'.$text.'</strong></a>';
    }

    public static function icon(string $icon, string $color = 'text-secondary', string $size = '1rem'):string
    {
        return '<i class="'.$icon.' '.$color.'" style="font-size: '.$size.';"></i>';
    }

     /**
     * Componenet HTML select (show options in select structure)
     *
     * @param array|null $list
     * @return string
     */
    public static function comboBox(?array $list, ?int $select = null, bool $novalue = false):string
    {
        $li = $novalue ? '' : '<option value=""></option>';
        foreach($list as $k=>$v){
            $slc  = ($select != null && $select == $k) ? 'selected' : '';
            $li  .= '<option value="'.$k.'"'.$slc.'>'.$v.'</option>';
        }
        return $li;
    }

    public static function comboBoxMult(string $name, ?string $value = '', array $list = [], string $desc = ''):string
    {
        //initialize list itens
        $items = '';
        
        //feed list itens
        asort($list);
        foreach($list as $key => $item)
        {
            $params = [
                'id_item'    => 'item_'.$key.'_'.$name,
                'value_item' => $key,
                'name_item'  => $item,
                'class_item' => 'itemcheck'.$name
            ];
            $items .= View::renderView('components/select_mult_item', $params);
        }

        $multiParams = [
            'name_input'  => $name,
            'desc_input'  => $desc,
            'value_input' => $value,
            'list_input'  => $items

        ];

        return View::renderView('components/select_mult', $multiParams);
    }

    public static function formtxtinput(string $nome, string $id, bool $mandatory = true, string $class = '', string $placeholder = ''):string
    {

        $indicator   = $mandatory ? ' <span class="text-danger small">*</span>' : '';
        $ismandatory = $mandatory ? 'ocp-mandatory' : '';

        return '<div class="col-sm-12 col-md-6 col-lg-4">
                <label for="'.$id.'" class="form-label col-form-label small text-truncate">
                    '.$nome.$indicator.'
                </label>
                <input type="text" name="'.$id.'" id="'.$id.'"
                    class="form-control ocp-input-form '.$ismandatory.' '.$class.'" 
                    placeholder="'.$placeholder.'"
                    value="">
            </div>';
    }

    public static function input(string $nome,string $id,bool $mandatory = false,string $class = '',string $placeholder = '',string $title = '',string $defvalue = '0'):string
    {
        $ismandatory = $mandatory ? 'ocp-mandatory' : '';
        return '<input type="text" name="'.$nome.$id.'" id="'.$nome.$id.'"
                    class="form-control '.$ismandatory.' '.$class.'" 
                    placeholder="'.$placeholder.'" title="'.$title.'"
                    value="'.$defvalue.'">';
    }

    public static function select(string $nome, string $id, array $values = [], int $default = 1, bool $mandatory = false, string $class = ''):string
    {
        $ismandatory = $mandatory ? 'ocp-mandatory' : '';
        return '<select  name="'.$nome.$id.'" id="'.$nome.$id.'"
                class="form-control '.$ismandatory.' '.$class.'">
                '.self::comboBox($values, $default, true).'
                </select>';
    }

    public static function imgRender(?string $path, string $alt = '', string $class = ''):string
    {
        return $path != null
        ? '<img class="'.$class.'" src="uploads/'.$path.'" alt="'.$alt.'" />'
        : '';
    }

    public static function imgView(?string $path):string
    {
        return $path != null
        ? '<img src="uploads/'.$path.'" alt="" class="ocp-picture-imgform mx-auto"/>'
        : '<i class="bi-image-alt text-secondary" style="font-size: 5rem;"></i>';
    }

    public static function imgReport(?string $path, string $alt = '', string $class = ''):string
    {
        return $path != null
        ? '<img class="'.$class.'" src="'.__DIR__.'/../../uploads/'.$path.'" alt="'.$alt.'" />'
        : '';
    }

    public static function imgReport64(?string $img64, string $alt = 'QrCode'):string
    {
        return $img64 != null
        ? '<img src="data:image/png;base64, '.$img64.' " alt="'.$alt.'">'
        : '';
    }

    /**
     * Method render a generic table with data array
     *
     * @param array $body
     * @param array|null $header
     * @param bool $count
     * @param bool $action
     * @return string
     */
    public static function genericTable(array $body = [], ?array $header = null, bool $count = true):string
    {
        //build cout total regiters
        $total = $count ? '<span class="badge bg-base my-3">'.count($body).' Registros Exibidos</span>' : '';
        
        //build header table
        $top  = $header != null ? '<thead><tr>' : '';
        $top .= ($header != null && $count) ? '<th>#</th>' : '';
        if($header != null){foreach ($header as $col) { $top .= '<th>'.$col.'</th>';}}
        $top .= $header != null ? '</tr></thead>' : '';

        //build body table
        $nline   = 1;
        $filling = '';
        foreach($body as $line){
            $filling .= '<tr>';
            $filling .= $count ? '<td>'.$nline++.'</td>' : '';
            foreach($line as $col){ $filling .= '<td>'.$col.'</td>'; }
            $filling .= '</tr>';
        }

        //build table
        $table  = '';
        if($body != null)
        {
            $table  = '<table class="table table-striped table-borderless ocp-table">';
            $table .= $top.$filling;
            $table .= '</table>';
        }

        return $total.$table;
    }

    public static function actionMenu(int $id, string $type):string
    {
        $urledit = Route::route(['action' => 'json', 'key' => $id]);

        $edit = '<li>
                    <a class="dropdown-item ocpedit" href="#" ocpurl="'.$urledit.'">
                        <i class="bi-pencil me-1"></i>
                        Editar
                    </a>
                </li>';

        $delet = '<li>
                    <a class="dropdown-item ocpdelete" href="#" data-bs-toggle="modal" data-bs-target="#modalDell" deleteid="'.$id.'">
                        <i class="bi-trash3 me-1"></i>
                        Excluir
                    </a>
                </li>';

        $folha = '<li>
                    <a class="dropdown-item" target="_blank" href="'.Route::route(['action'=> 'export', 'key'=>$id]).'">
                        <i class="bi-file-pdf me-1"></i>
                        Exportar PDF
                    </a>
                </li>';

        


        $action = match($type){
            'admin'        => ['tab_nav_action_intens' => $edit.$delet],
            'adminfolha'   => ['tab_nav_action_intens' => $folha],
            default        => ['tab_nav_action_intens' => '']
        };

        return View::renderView('components/nav_tab_action', $action);
    }
}