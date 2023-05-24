<?php
namespace Octus\App\Controller\Pages;

class Home extends Page
{
    public function viepage():string
    {
        $params = [];

        return $this->getPage('Inicio', 'pages/home', $params);
    }
}