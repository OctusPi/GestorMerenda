<?php
namespace Octus\App\Controller\Pages;

use Octus\App\Controller\Components\ActionBuilder;
use Octus\App\Controller\Components\DataList;
use Octus\App\Utils\Html;
use Octus\App\Utils\Utils;
use Octus\App\Utils\View;
use Octus\App\Utils\Dates;
use Octus\App\Utils\Forms;
use Octus\App\Utils\Route;
use Octus\App\Utils\Alerts;
use Octus\App\Utils\Emails;
use Octus\App\Utils\Session;
use Octus\App\Utils\Security;
use Octus\App\Model\EntityUsuario;
use Octus\App\Controller\Pages\Page;
use Octus\App\Data\FactoryDao;

class Admin extends Page
{
    public function __construct(Session $session, ?EntityUsuario $usuario = null)
    {
        parent::__construct($session, $usuario, true, EntityUsuario::PRF_ADMIN, EntityUsuario::NVL_BIGBOSS);
    }

    /**
     * Render view page html
     *
     * @return string
     */
    public function viewpage():string
    {
        $params = [
            'form_search'   => View::renderView('fragments/forms/search/admin'),
            'search_action' => Route::route(['action'=>'view']),
            'action'        => Route::route(['action'=>'send']),
            'form_secretarias' => Html::comboBox(DataList::listSecretarias($this->usuario)),
            'form_departamentos' => Html::comboBox(DataList::listUnidades($this->usuario)),
            'form_perfis'   => Html::comboBox(EntityUsuario::getPerfilArr()),
            'form_status'   => Html::comboBox(EntityUsuario::getStatusArr(), novalue:true),
            'data_page'     => json_decode($this->datahtml())->{'view'}
        ];

        return $this->getPage('Gestão Sistema', 'pages/admin', $params);
    }
    
    /**
     * Proccess request form insert or up data in page
     *
     * @return string
     */
    public function proccess():string
    {

        //insert and update
        if(Forms::validForm('token', EntityUsuario::getObrPropsClass())){

            $user  = new EntityUsuario();
            $user -> feedsEntity(Forms::getPost());
            $user -> setAttr('uid', hash('sha256', $user->getAttr('cpf')));
            $user -> setAttr('agente', $this->usuario->getAttr('id'));
            $user -> buildNivel($user->getAttr('perfil'));

            //check is new user and generate randon temp passwd
            $isnew   = $user->getAttr('id') == 0;
            $tmppass = $user->getAttr('cpf');//Security::randonPass();

            if($isnew)
            {
                $user->setAttr('pid', hash('sha256', $tmppass));
                $user->setAttr('passchange', 1);
            }

            //execute DAO and return alerts states
            $facDAO = (new FactoryDao())->daoUsuario($user);
            $wrtDAO = $facDAO -> writeData();
            
            if($wrtDAO['status']){
            
                if($isnew){
                    $smail = Emails::send(Emails::NEWUSER, $facDAO->getEntity(), $this->company, ['tmppass' => $tmppass]);
                    return Alerts::notify(
                        $wrtDAO['code'],
                        $smail ? 'E-mail com senha temporaria enviada' : 'Senha inicial será o CPF do Usário',
                        $this->datahtml(), $user->getAttr('id'), $this->usuario
                    );
                }

                return Alerts::notify(
                    $wrtDAO['code'],
                    'Dados do usuáio '.$user->getAttr('nome').' foram alterados',
                    $this->datahtml(), $user->getAttr('id'), $this->usuario);
            }else{
                return Alerts::notify($wrtDAO['code'], 'Não Houveram Alterações', $this->datahtml(), $user->getAttr('id'), usuario:$this->usuario);
            }
            
        }

        //delete iten
        if(Forms::validForm('token_trash', ['id', 'passconfirm'])){
           
            $params = Forms::getPost(['id', 'passconfirm']);
            if($this->usuario->getAttr('pid') == hash('sha256', $params['passconfirm'])){

                $user =  new EntityUsuario();
                $user -> feedsEntity($params);

                $facDAO = (new FactoryDao())->daoUsuario($user);
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
        $params = $params == null ? $getid : $params;
        
        $facDAO = (new FactoryDao())->daoUsuario();
        $facDAO->readData($params);
        return json_encode([
            'values' => $facDAO->getEntity()->getPropsAndValues()
        ]);
    }

    public function datahtml():string
    {
        $facDAO  = (new FactoryDao)->daoUsuario();
        $getDAO  = $facDAO->readData($this->search(), true, 'nome');
        $tabKeys = ['Identificaçao', 'Perfil', 'Ultimo Acesso', ''];
        $tabBody = [];

        //feed body
        if($getDAO != null)
        {
            foreach($getDAO as $ent)
            {
                $tabBody[] = [
                    Html::pbig($ent->getAttr('nome'))
                   .Html::psmall($ent->getAttr('email')),

                    Html::pbig(EntityUsuario::getPerfilArr()[$ent->getAttr('perfil')])
                   .Html::psmall(EntityUsuario::getStatusArr()[$ent->getAttr('status')], 
                    EntityUsuario::getStatusColorArr()[$ent->getAttr('status')]),

                    Html::psmall(
                        $ent->getAttr('nowlogin') != null 
                        ? Dates::fmttDateTimeView($ent->getAttr('nowlogin'))
                        : 'Nunca Acessou'
                    ).Html::psmall('CPF: '.$ent->getAttr('cpf')),
                    
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
        $fields = ['nome', 'perfil'];

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