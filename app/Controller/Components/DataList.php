<?php
namespace Octus\App\Controller\Components;

use Octus\App\Data\FactoryDao;
use Octus\App\Model\EntityUsuario;
use Octus\App\Utils\Security;

class DataList
{

    /**
     * Data list generic entity
     * @param string $molde
     * @param string $key
     * @param mixed $value
     * @return array
     */
    public static function list(string $molde, string $key = 'id', string $value = 'nome', array $where = []):array
    {
        $facDAO = (new FactoryDao())->$molde();
        $getDAO = $facDAO->readData($where, true, $value, columns:$key.','.$value);
        $lstDAO = [];
        
        //feed list
        foreach ($getDAO as $item) {
            $lstDAO[$item->getAttr($key)] = $item->getAttr($value);
        }
        return $lstDAO;
    }

    public static function listSecretarias(?EntityUsuario $user):array
    {
        $facDAO = (new FactoryDao())->daoSecretaria();
        $getDAO = $facDAO->readData(all:true, order:'secretaria', columns:'id,secretaria');
        $lstDAO = [];

        //feed list
        if($getDAO != null){
            foreach ($getDAO as $item) {
                if(Security::isAuthList($user, $item->getAttr('id'))){
                    $lstDAO[$item->getAttr('id')] = $item->getAttr('secretaria');
                }
            }
        }
        return $lstDAO;
    }

    public static function listUnidades(?EntityUsuario $user):array
    {
        $facDAO = (new FactoryDao())->daoUnidade();
        $getDAO = $facDAO->readData(all:true, order:'unidade', columns:'id,unidade,secretaria');
        $lstDAO = [];

        //feed list
        if($getDAO != null){
            foreach ($getDAO as $item) {
                if(Security::isAuthList($user, $item->getAttr('secretaria'), $item->getAttr('id'))){
                    $lstDAO[$item->getAttr('id')] = $item->getAttr('unidade');
                }
            }
        }
        return $lstDAO;
    }
}