<?php
namespace Octus\App\Model;
use Octus\App\Data\ConnDB;

class EntityEstoque extends Entity
{
    protected int|EntityInsumo $insumo;
    protected int|EntitySecretaria $secretaria;
    protected null|int|EntityDepartamento $departamento;
    protected int $quantidade;
    protected string $dtcreate;
    protected ?string $dtupdate;
    protected int $agente;


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
        return ConnDB::TAB_ESTOQ;
    }

    /**
     * Method return array with exclusive properties to entity
     *
     * @return array
     */
    public function getExclusivePropsClass():array
    {
        return ['insumo', 'secretaria', 'departamento'];
    }

}