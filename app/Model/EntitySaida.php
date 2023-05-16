<?php
namespace Octus\App\Model;
use Octus\App\Data\ConnDB;

class EntitySaida extends Entity
{
    protected ?int $origem;
    protected int|EntitySecretaria $secretaria;
    protected null|int|EntityDepartamento $departamento;
    protected string $insumos;
    protected int $status;
    protected ?string $dtcreate;
    protected ?string $dtupdate;
    protected int $agente;

    public function __construct()
    {
        parent::__construct();
    }

    public function setInsumos(array $insumos):void
    {
        $this->insumos = serialize($insumos);
    }

    public function getInsumos():array
    {
        return unserialize($this->insumos);
    }

     /**
     * Return name of table in database reference entity
     * @override
     * @return string|null
     */
    public function getDataTableEntity(): ?string 
    {
        return ConnDB::TAB_SAIDS;
    }

    /**
     * Return array with mandatory propertys of class
     *
     * @return array
     */
    public static function getObrPropsClass():array
    {
        return ['secretaria'];
    }

    public static function statusArr():array
    {
        return [
            1 => 'Em Processamento',
            2 => 'Processada',
            3 => 'Cancelada',
        ];
    }
}