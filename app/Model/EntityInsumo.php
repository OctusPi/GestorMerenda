<?php
namespace Octus\App\Model;

use Octus\App\Data\ConnDB;

class EntityInsumo extends Entity
{

    protected string $ingrediente;
    protected string $percapitas;
    protected ?string $calorias;
    protected ?string $carboidratos;
    protected ?string $proteinas;
    protected ?string $lipidios;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Return name of table in database reference entity
     * @override
     * @return string|null
     */
    public function getDataTableEntity(): ?string 
    {
        return ConnDB::TAB_INSMS;
    }

    /**
     * Method return array with exclusive properties to entity
     *
     * @return array
     */
    public function getExclusivePropsClass():array
    {
        return ['departamento', 'secretaria'];
    }

    /**
     * Return array with mandatory propertys of class
     *
     * @return array
     */
    public static function getObrPropsClass():array
    {
        return ['departamento', 'secretaria'];
    }
}