<?php
namespace Octus\App\Model;
use Octus\App\Data\ConnDB;

class EntityHistory extends Entity
{
    protected int $tipo;
    protected int $origem;
    protected ?string $observacao;
    protected int $status;
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
        return ConnDB::TAB_HISTR;
    }

    public static function tipoArr():array
    {
        return [
            1 => 'Entrada',
            2 => 'Saída',
        ];
    }
    
    public static function statusArr(int $tipo):array
    {
        return match($tipo)
        {
            1 => EntityEntrada::statusArr(),
            2 => EntitySaida::statusArr(),
            default => []
        };
    }
}