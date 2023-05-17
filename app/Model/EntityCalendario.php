<?php
namespace Octus\App\Model;
use Octus\App\Data\ConnDB;

class EntityCalendario extends Entity
{
    protected int $secretaria;
    protected int $ano;
    protected string $data;
    protected ?string $observacao;
    protected int $tipo;

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
        return ConnDB::TAB_CALEND;
    }

    /**
     * Method return array with exclusive properties to entity
     *
     * @return array
     */
    public function getExclusivePropsClass():array
    {
        return ['data'];
    }

    /**
     * Return array with mandatory propertys of class
     *
     * @return array
     */
    public static function getObrPropsClass():array
    {
        return ['secretaria', 'data'];
    }

    public static function tipoArr():array
    {
        return [
            1 => 'Letivo',
            2 => 'Feriado',
            3 => 'Ponto Facultativo',
            4 => 'Remanejado'
        ];
    }
}