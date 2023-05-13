<?php
namespace Octus\App\Data;

use Exception;
use Octus\App\Model\Entity;
use Octus\App\Utils\Alerts;
use Octus\App\Data\Dao;

class ImpDao extends Dao
{
    public function __construct(Entity $entity)
    {
        parent::__construct($entity);
    }

    /**
     * Method write data in database after verify is data exists and if isOnly, return json 
     * with two objects, status | entity with info status and data entity respectively 
     * 
     * @param array $params
     * @return string
     */
    public function writeData():array
    {
        //verify is only in database
        $isOnly = $this->isOnly();

        if($isOnly){
            try{
                $write = $this->isExists() ? $this->daoUp() : $this->daoIn();
                return [
                    'code'   => Alerts::STATUS_OK,
                    'status' => $write
                ];
            }catch(Exception $e){
                return [
                    'code'   => Alerts::STATUS_FAIL,
                    'status' => false
                ];
            }
            
        }else{
            return [
                'code'   => Alerts::STATUS_DUPLI,
                'status' => false
            ];
        }
    }

    /**
     * Method rescue register in database and return entity null or array
     *
     * @param array $params
     * @param bool $all
     * @param string $order
     * @param string $limit
     * @param string $mode
     * @return null|Entity|array
     */
    public function readData(array $params = [], bool $all = false, string $order = '', string $limit = '', string $mode = ' AND ', string $columns = '*'):null|Entity|array
    {
        return $all ? 
        $this->daoGetAll($params, $order, $limit, $mode, $columns) : 
        $this->daoGetOne($params, $mode, $columns);
    }

    /**
     * Method rescue register in database with inner join tables and return entity null or array
     *
     * @param array $joins //array associative key = inner table and values = fields table
     * @param array $params // params tosearch where
     * @param string $order
     * @param string $limit
     * @param string $mode
     * @param string $columns
     * @return array|null
     */
    public function readDataJoin(array $joins = [], array $params = [], string $order = '', string $limit = '', string $mode = ' AND ', string $columns = '*'):?array
    {
        return $this->daoGetJoin($joins, $params, $order, $limit, $mode, $columns);
    }

    /**
     * execute delete and retur string json with status and data entity deleted
     *
     * @param null|array $params
     * @return array
     */
    public function delData(?array $params = null, bool $all = false):array
    {

        //execute delete and retur string json with status and data entity deleted
        $delete = $this->daoDel($params, $all);

        //return array two keys -> code exit and status request
        return[
            'code'   => $delete ? Alerts::STATUS_OK : Alerts::STATUS_WARNING,
            'status' => $delete ? 'Exclusão Realizada.' : 'Item referenciado em outras instancias'
        ];
    }
}
