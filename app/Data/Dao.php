<?php
namespace Octus\App\Data;

use PDO;
use Exception;

use Octus\App\Utils\Logs;
use Octus\App\Model\Entity;
use Octus\App\Data\ConnDB;

abstract class Dao implements IDao
{
    /**
     * Entity to Data Access Object
     *
     * @var Entity
     */
    protected Entity $entity;

    /**
     * Construct of class
     *
     * @param Entity $entity
     */
    public function __construct(Entity $entity)
    {
        $this->entity = $entity;
    }

    /**
     * get entity of data acces object
     *
     * @return Entity
     */
    public function getEntity():Entity
    {
        return $this->entity;
    }

    /**
     * Method checks if entity exists in the database by its unique identifier
     *
     * @return bool
     */
    public function isExists():bool
    {
        $sql = 'SELECT * FROM '.$this->getEntity()->getDataTableEntity()
        .' WHERE id = '.$this->getEntity()->getAttr('id');

        return $this->execQueryBool($sql);
    }

    /**
     * Checks is entity is single in data base with param search
     *
     * @param array $params | these parameters are to check if values ​​that cannot be replicated already exist in the database
     * @return bool
     */
    public function isOnly():bool
    {
        //rescue values of entity and create binds and fields to search
        $params = $this->getEntity()->getExclusivePropsClass();
        $search = $this->getEntity()->getSomeValuesClass($params);
        $binds  = array_map(function($item){ return $item.'=?';}, $params);
        $fields = $params != null ? ' WHERE '.implode(' AND ', $binds).' AND ' : '';
        
        
        $sql = 'SELECT * FROM '.$this->getEntity()->getDataTableEntity()
        .$fields.'id != '.$this->getEntity()->getAttr('id');

        //if params diff null check database and feed entity, returno false se data found
        if($params != null){
            $food  =  $this->execQueryFetch($sql, $search);
            $this  -> getEntity()->feedsEntity($food);
            return $food == null;
        }

        return true;

    }

    /**
     * Method insert entity in data base and return your self
     *
     * @param array $params  | these parameters are to check if values ​​that cannot be replicated already exist in the database
     * @return bool
     */
    public function daoIn():bool
    {
        //rescue values initializeds in entity and remove last attr (id)
        $params  = $this->getEntity()->getPropsAndValues();
        
        //create binds with attrs entity and wildcards to values
        $binds  = implode(',', array_keys($params));
        $values = implode(',', array_map(function($item){ return '?'; }, $params));

        $sql = 'INSERT INTO '.$this->getEntity()->getDataTableEntity()
        .' ('.$binds.') VALUES ('.$values.')'; 

        return $this->execQueryFeed($sql, $params);
    }

    /**
     * Method update entity in data base with params and return your self
     *
     * @param array $params | these parameters are to check if values ​​that cannot be replicated already exist in the database
     * @return bool
     */
    public function daoUp():bool
    {
        //rescue values initializeds in entity and remove last attr (id)
        $params  = $this->getEntity()->getPropsAndValues();

        //create binds with attrs entity and wildcards to values
        $binds = implode(',', array_map(function($item){ return $item.'=?'; }, array_keys($params)));
        $sql   = 'UPDATE '.$this->getEntity()->getDataTableEntity().' SET '.$binds.' WHERE id = '.$this->getEntity()->getAttr('id');

        return $this->execQueryBool($sql, $params);
    }

    /**
     * Method delete entity in database
     *
     * @param array $params | params search entity to delete
     * @return bool|null
     */
    public function daoDel(?array $params = null, bool $all = false):bool
    {
        if($all)
        {
            $sql = 'DELETE FROM '.$this->getEntity()->getDataTableEntity();

        }else{
            $where = $params == null
            ? 'id = ' . $this->getEntity()->getAttr('id')
            : implode(' AND ', array_map(function ($col, $val) {
                return $col . ' = ' . $val;
            }, array_keys($params), $params));

            $sql = 'DELETE FROM '.$this->getEntity()->getDataTableEntity()
            .' WHERE '.$where;
        }
    
        return $this->execQueryBool($sql);
    }

    /**
     * method search and return one entity in table of database
     *
     * @param array $params | seach entity in table of database array key|value (key = column table)
     * @return Entity|null
     */
    public function daoGetOne(array $params = [], string $mode = ' AND ', string $columns = '*'):?Entity
    {
        //create binds and fields dynamic by entity and params search
        $params = $this->mapParams($params);
        $binds  = array_map($this->mapOperator(), array_keys($params), array_values($params));
        $fields = $params != null ? ' WHERE '. implode($mode, $binds) : '';
		$search = array_map($this->mapWildCard(), array_values($params));

        //make sql
        $sql = 'SELECT '.$columns.' FROM '.$this->getEntity()->getDataTableEntity().$fields;

        //execute query and feed entity
        $food = $this->execQueryFetch($sql, $search);
        if($food != null){
            $this->getEntity()->feedsEntity($food);
            return $this->getEntity();
        }else{
            return null;
        }
    }

    /**
     * method search and return so many entitys in table of database
     *
     * @param array $params | parameters of search 
     * @param string $order | order list values located
     * @param string $limit | limite lines rescue at a time
     * @param string $mode  | mode search params AND -- OR
     * @return array|null
     */
    public function daoGetAll(array $params = [], string $order = '', string $limit = '', string $mode = ' AND ', string $columns = '*'):?array
    {
        //create binds and fields dynamic by entity and params search
        $params = $this->mapParams($params);
        $binds  = array_map($this->mapOperator(), array_keys($params), array_values($params));
        $fields = $params != null ? ' WHERE '. implode($mode, $binds) : '';
		$search = $this->lineWildCard(array_map($this->mapWildCard(), array_values($params)));

        //make fields order and limit
        $order = strlen($order) ? ' ORDER BY '.$order : '';
        $limit = strlen($limit) ? ' LIMIT '.$limit : '';

        //make sql
        $sql = 'SELECT '.$columns.' FROM '.$this->getEntity()->getDataTableEntity().$fields.$order.$limit;

        //execute query and get array statment
        $entft = [];
        $fetch = $this->execQueryFetch($sql, $search, true);

        //loop statment end feed entity array
        if($fetch !=null){
            foreach ($fetch as $food) {
                $nmentity = $this->getEntity()->classname();
                $entity   = new $nmentity();
                $entity  -> feedsEntity($food);
                $entft[]  = $entity;
            }
        }
        return $entft;
    }

    /**
     * method search and return so many entitys in tables joined of database 
     *
     * @param array $joins  | tables to join ($key = table | $value = ON join field)
     * @param array $params | parameters of search 
     * @param string $order | order list values located
     * @param string $limit | limite lines rescue at a time
     * @param string $mode  | mode search params AND -- OR
     * @return array|null
     */
    public function daoGetJoin(array $joins, array $params = [], string $order = '', string $limit = '', string $mode = ' AND ', string $columns = '*'):?array
    {

        //make join values and concatene tables
		$mapfields = array_map($this->mapJoin(), array_keys($joins), array_values($joins));
        $maptabs   = array_map(
            function($chave, $valor){
                return $chave.' ON '.$valor;
            },
            array_keys($joins), 
            array_values($mapfields)
        );
        $innerjoin = ' INNER JOIN '.implode(' INNER JOIN ', $maptabs);

        //params search, case null use entity props
        $params = $this->mapParams($params);

        //map operators sql where
        $binds  = array_map($this->mapOperator(), array_keys($params), array_values($params));
        
        //concatene binds in fields with mode search
        $fields = $params != null ? ' WHERE '. implode($mode, $binds) : '';
        $search = $this->lineWildCard(array_map($this->mapWildCard(), $params));

        //make fields order and limit
        $order = strlen($order) ? ' ORDER BY '.$order : '';
        $limit = strlen($limit) ? ' LIMIT '.$limit : '';

        //make sql
        $sql = 'SELECT '.$columns.' FROM '.$this->getEntity()->getDataTableEntity().$innerjoin.$fields.$order.$limit;

        //execute query and return array statment
        return $this->execQueryFetch($sql, $search, true);
    }

    /**
     * Method Mapper Params - if no search parameter is passed, use the data feed into the entity
     *
     * @param array|null $params
     * @return array|null
     */
    private function mapParams(?array $params):?array
    {
        if($params == null){
            $params = $this->getEntity()->getPropsAndValues();
            array_pop($params);
        }

        return $params;
    }

    /**
	 * return operator to mount sql in accord with type value search
	 *
	 * @param mixed $item
	 * @return callable
	 */
	private function mapOperator():callable
    {
        $defineOperator = function($item, $value){
           
            $operator = match(true){
				is_array($value)   => ' BETWEEN ? AND ? ',
                is_numeric($value) => ' = ? ',
				is_string($value)  => ' LIKE ? ',
				default            => ' = ? '
		   };

		   return $item.$operator;
        };

        return $defineOperator;
    }
	
	/**
	 * return wild card to mount array values execute sql in accord with type value search
	 *
	 * @param mixed $item
	 * @return callable
	 */
	private function mapWildCard():callable
    {
        $defineWC = function($item){
           return match(true){
                is_numeric($item) => $item,
				is_string($item)  => '%'.$item.'%',
				default 		  => $item
		   };
        };

        return $defineWC;
    }

	/**
	 * Mapping join tables and respective fiends
	 *
	 * @return callable
	 */
    private function mapJoin():callable
    {
        $mapJoin = function($table, $campos){
            //initialize arrays to insert rigth values to join operation and define primary table
			$binds		= [];
			$join 		= [];
            $tabprimaty = $this->getEntity()->getDataTableEntity();

			//concatene tables with field by position in array
            foreach ($campos as $key => $campo) {
               if($key == 0 || $key%2 == 0){
					$binds[] = $tabprimaty.'.'.$campo;
               }else{
					$binds[] = $table.'.'.$campo;
               }
            }

			//unify fields and feed array join
			foreach (array_keys($binds) as $k) {
				if($k > 0 && $k%2 != 0){
					$join[] = $binds[$k-1].' = '.$binds[$k];
				}
			}

			return implode(' AND ', $join);
        };

        return $mapJoin;
    }

    /**
     * Method convert array of arrays and one unique array to exec PDO Join with BETWEEN Operator
     * @param array|null $mapwild
     * @return array
     */
    private function lineWildCard(array $mapwild, array $merge = []):array
    {

        if($mapwild != null){
            foreach ($mapwild as $map) {
                if(is_array($map)){
                    $this->lineWildCard($map, $merge);
                }else{
                    $merge[] = $map;
                }
            }
        }
        return $merge;
    }

    /**
     * Run Query DAO and return bool if find any register in Database
     *
     * @param string $sql
     * @param array $params
     * @return bool
     */
    private function execQueryBool(string $sql, array $params = []):bool
    {
        //default return method
        $exec = false;

        try{
            $connDB    =  ConnDB::openConn();
            $params    =  $params != null ? array_values($params) : [];
            $execQuery =  $connDB->prepare($sql);
            $execQuery -> execute($params);
            $exec      =  $execQuery->rowCount() > 0;
        }catch(Exception $e){
            Logs::writeLog('ERROR: '.$e->getMessage());
        }finally{
            ConnDB::closeConn();
        }

        return $exec;
    }

    /**
     * Run Query DAO and return bool if insert record in database also feed antity last insered id
     *
     * @param string $sql
     * @param array $params
     * @return bool
     */
    private function execQueryFeed(string $sql, array $params = []):bool
    {
        //default return method
        $exec = false;

        try{
            $connDB    =  ConnDB::openConn();
            $params    =  $params != null ? array_values($params) : [];
            $execQuery =  $connDB->prepare($sql);
            $execQuery -> execute($params);
            $exec      =  $execQuery->rowCount() > 0;

            //feed entity with last inserted id in database
            if($exec){
                $this->getEntity()->setAttr('id', $connDB->lastInsertId());
            }

        }catch(Exception $e){
            Logs::writeLog('ERROR: '.$e->getMessage());
            throw new Exception($e->getMessage());
        }finally{
            ConnDB::closeConn();
        }

        return $exec;
    }

    /**
     * Run Query DAO and return statment array find in database
     *
     * @param string $sql
     * @param array $params
     * @param bool $all | bool return one or all records found
     * @return array
     */
    private function execQueryFetch(string $sql, array $params = [], bool $all = false):?array
    {
        //Logs::writeLog($sql);
        //default return method
        $exec = [];

        try{
            $connDB    =  ConnDB::openConn();
            $params    =  $params != null ? array_values($params) : [];
            $execQuery =  $connDB->prepare($sql);
            $execQuery -> execute($params);
            if($execQuery->rowCount() > 0){
                $exec = $all ? $execQuery->fetchAll(PDO::FETCH_NAMED) : $execQuery->fetch(PDO::FETCH_ASSOC);
            }
        }catch(Exception $e){
            Logs::writeLog('ERROR: '.$e->getMessage());
            throw new Exception($e->getMessage());
        }finally{
            ConnDB::closeConn();
            return $exec;
        }
    }
}