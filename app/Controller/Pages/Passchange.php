<?php
namespace Octus\App\Controller\Pages;

use Octus\App\Model\EntityUsuario;
use Octus\App\Utils\Forms;
use Octus\App\Utils\Route;
use Octus\App\Utils\Utils;
use Octus\App\Utils\Alerts;
use Octus\App\Utils\Emails;
use Octus\App\Utils\Session;
use Octus\App\Utils\Security;
use Octus\App\Data\FactoryDao;
use Octus\App\Controller\Pages\Page;

class Passchange extends Page
{
    public function __construct(Session $session, ?EntityUsuario $usuario = null)
    {
        parent::__construct($session, $usuario, false);
        
        //checks request change temp passwd
        if(!Utils::atob('passchange', $this->usuario)){
            Security::redirect('?app=home');
        }
    }

    public function viewpage():string
    {
        $params = [
            'action'    => Route::route(['action'=>'send']),
            'user_name' => Utils::atob('nome', $this->usuario),
            'user_mail' => Utils::atob('email', $this->usuario)
        ];

        return $this->getPage('Mudar Senha', 'pages/passchange', $params, false, false);
    }

    public function proccess():string
    {
        if(Forms::validForm('token', array_keys($_POST))){
            
            //rescue and sanitize post key|values
            $posts  = Forms::getPost();
            $ispass = Security::isPassValid(Utils::at('newpass', $posts), Utils::at('reppass', $posts), Utils::at('oldpass', $posts));

            if($ispass['status']){
                if($this->usuario->getAttr('pid') == hash('sha256', Utils::at('oldpass', $posts) ?? '*'))
                {
                    $this->usuario->setAttr('pid', hash('sha256',Utils::at('newpass', $posts)));
                    $this->usuario->setAttr('passchange', 0);
                    $facDAO = (new FactoryDao())->daoUsuario($this->usuario);
                    $wrtDAO = $facDAO->writeData();

                    if($wrtDAO['status']){
                        Emails::send(Emails::CHGPASS, $this->usuario, $this->company);
                        Security::redirect();
                        return Alerts::notify($wrtDAO['code'], 'Senha alterada com sucesso!');
                    }else{
                        return Alerts::notify($wrtDAO['code'], 'Não foi possível alterar a senha temporária');
                    }
                }else{
                    return Alerts::notify(Alerts::STATUS_WARNING, 'Senha atual incorreta!'); 
                }
            }else{
                return Alerts::notify(Alerts::STATUS_WARNING, $ispass['message']);
            }
        }else{
            return Alerts::notify(Alerts::STATUS_WARNING, 'Formulario inválido, atualize a página e tente novamente...',);
        }
    }
}