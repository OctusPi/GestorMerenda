<?php
namespace Octus\App\Controller\Pages;

use Octus\App\Controller\Components\ActionBuilder;
use Octus\App\Controller\Components\DataList;
use Octus\App\Model\EntitySecretaria;
use Octus\App\Utils\Html;
use Octus\App\Utils\Utils;
use Octus\App\Utils\View;
use Octus\App\Utils\Dates;
use Octus\App\Utils\Forms;
use Octus\App\Utils\Route;
use Octus\App\Utils\Alerts;
use Octus\App\Utils\Session;
use Octus\App\Model\EntityUsuario;
use Octus\App\Controller\Pages\Page;
use Octus\App\Data\FactoryDao;

class Secretarias extends Page
{
    public function __construct(Session $session, ?EntityUsuario $usuario = null)
    {
        parent::__construct($session, $usuario, true, EntityUsuario::PRF_ADMIN, EntityUsuario::NVL_SECRETARIAS);
    }

    /**
     * Render view page html
     *
     * @return string
     */
    public function viewpage():string
    {
        $params = [
            'form_search'   => View::renderView('fragments/forms/search/secretarias'),
            'search_action' => Route::route(['action'=>'view']),
            'action'        => Route::route(['action'=>'send']),
            'data_page'     => json_decode($this->datahtml())->{'view'}
        ];

        return $this->getPage('Gestão de Secretarias', 'pages/secretarias', $params);
    }
    
    /**
     * Proccess request form insert or up data in page
     *
     * @return string
     */
    public function proccess():string
    {

        //insert and update
        if(Forms::validForm('token', EntitySecretaria::getObrPropsClass())){

            //execute DAO and return alerts states
            $facDAO = (new FactoryDao())->daoSecretaria();
            $facDAO -> getEntity()->feedsEntity(Forms::getPost());
            $facDAO -> getEntity()->setAttr('agente', $this->usuario->getAttr('id'));
            $wrtDAO = $facDAO -> writeData();
            
            if($wrtDAO['status']){
                return Alerts::notify(
                    $wrtDAO['code'],
                    '',
                    $this->datahtml(),
                    $facDAO->getEntity()->getAttr('id'),
                    $this->usuario
                );
            }else{
                return Alerts::notify($wrtDAO['code'], 'Não foram feitas alterações', $this->datahtml(), $facDAO->getEntity()->getAttr('id'), $this->usuario);
            }
            
        }

        //delete iten
        if(Forms::validForm('token_trash', ['id', 'passconfirm'])){
           
            $params = Forms::getPost(['id', 'passconfirm']);
            if($this->usuario->getAttr('pid') == hash('sha256', $params['passconfirm'])){

                $entity =  new EntitySecretaria();
                $entity -> feedsEntity($params);

                $facDAO = (new FactoryDao())->daoSecretaria($entity);
                $excDAO = $facDAO->delData();

                return Alerts::notify(
                    $excDAO['code'],
                    $excDAO['status'],
                    $this->datahtml(),
                    null,
                    $this->usuario
                );
            
            }else{
                return Alerts::notify(Alerts::STATUS_WARNING, 'Senha de validaçao incorreta', usuario:$this->usuario);
            }
        }

        return Alerts::notify(Alerts::STATUS_WARNING, 'Formulario inválido, atualize a página e tente novamente...', usuario:$this->usuario);
    }

    public function datajson(?array $params = null):string
    {
        $getid  = ['id'=>Route::gets()['key']];
        $facDAO = (new FactoryDao())->daoSecretaria();
        $facDAO->readData($params ?? $getid);
        return json_encode([
            'values' => $facDAO->getEntity()->getPropsAndValues()
        ]);
    }

    public function datahtml():string
    {
        $facDAO  = (new FactoryDao)->daoSecretaria();
        $getDAO  = $facDAO->readData($this->search(), true, 'secretaria');
        $tabKeys = ['Identificaçao', 'Localização', 'Autor', ''];
        $tabBody = [];

        //feed body
        if($getDAO != null)
        {
            foreach($getDAO as $ent)
            {
                $tabBody[] = [
                    Html::pbig($ent->getAttr('secretaria'))
                   .Html::psmall($ent->getAttr('cnpj')),

                   Html::psmall($ent->getAttr('endereco'))
                  .Html::psmall($ent->getAttr('telefone'))
                  .Html::psmall($ent->getAttr('email')),

                  Html::psmall('Resp. '. Utils::at($ent->getAttr('agente'), DataList::list('daoUsuario'))).
                  Html::psmall(Dates::fmttDateTimeView($ent->getAttr('dtupdate') ?? $ent->getAttr('dtcreate'))),
                    
                   ActionBuilder::build(['edit', 'delete'], $ent->getAttr('id'))
                ];
            }
        }

        return json_encode([
            'view' => Html::genericTable($tabBody, $tabKeys)
        ]);
        
    }

    /**
     * method proccess form search
     *
     * @return array
     */
    private function search():array
    {
        $fields = ['secretaria'];

        //search sending with searchform
        if(Forms::validForm('token_search')){
            return array_filter(Forms::getPost($fields));
        }
        //search sending with register or delete form
        else{ 
            if(Forms::validForm('token') || Forms::validForm('token_trash')){
                $search = Utils::at('search', Forms::getPost(['search']));
                return array_filter(Utils::urlsearch($search, $fields));
            }else{
                return [];
            }
        }
    }
}