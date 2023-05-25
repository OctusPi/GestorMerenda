<?php
namespace Octus\App\Controller\Pages;
use Octus\App\Model\EntityUsuario;
use Octus\App\Utils\Session;

class Home extends Page
{
    public function __construct(Session $session, ?EntityUsuario $usuario = null)
    {
        parent::__construct($session, $usuario);
    }

    public function viewpage():string
    {
        $params = [];

        return $this->getPage('Inicio', 'pages/home', $params);
    }
}