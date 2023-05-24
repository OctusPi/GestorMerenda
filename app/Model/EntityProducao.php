<?php
namespace Octus\App\Model;
use Octus\App\Data\ConnDB;

class EntityProducao extends Entity
{
    protected string $data;
    protected int|EntitySecretaria $secretaria;
    protected int|EntityDepartamento $departamento;
    protected string $producao;
    protected int|EntitySaida $saida;
    protected ?string $observacao;
    protected string $dtcreate;
    protected ?string $dtupdate;
    protected int $agente;

    public function __construct()
    {
        parent::__construct();
    }

    public function setProducao(array $producao):void
    {
        $this->producao = serialize($producao);
    }

    public function getProducao():array
    {
        return unserialize($this->producao);
    }

    /**
     * Return name of table in database reference entity
     * @override
     * @return string|null
     */
    public function getDataTableEntity(): ?string 
    {
        return ConnDB::TAB_PRODU;
    }

    /**
     * Method return array with exclusive properties to entity
     *
     * @return array
     */
    public function getExclusivePropsClass():array
    {
        return ['data', 'secretaria', 'departamento'];
    }

    /**
     * Return array with mandatory propertys of class
     *
     * @return array
     */
    public static function getObrPropsClass():array
    {
        return ['data', 'secretaria', 'departamento'];
    }
}