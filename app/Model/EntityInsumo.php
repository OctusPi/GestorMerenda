<?php
namespace Octus\App\Model;

use Octus\App\Data\ConnDB;

class EntityInsumo extends Entity
{
    protected string $insumo;
    protected string $percapitas;
    protected int $tipo;
    protected int $medida;
    protected int $qtalerta;
    protected ?string $dtcreate;
    protected ?string $dtupdate;
    protected int $agente;

    public function __construct()
    {
        parent::__construct();
    }

    public function setPercapitas(array $percapitas):void
    {
        $this->percapitas = serialize($percapitas);
    }

    public function getPercapitas():array
    {
        return unserialize($this->percapitas);
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
        return ['insumo'];
    }

    /**
     * Return array with mandatory propertys of class
     *
     * @return array
     */
    public static function getObrPropsClass():array
    {
        return ['insumo', 'tipo', 'medida'];
    }

    public static function tipoArr():array
    {
        return [
            1  => 'Cereais, pães e tubérculos',
            2  => 'Hortaliças',
            3  => 'Frutas',
            4  => 'Leguminosas',
            5  => 'Carnes e ovos',
            6  => 'Leite e derivados',
            7  => 'Óleos e gorduras',
            8  => 'Açúcares e doces',
            9  => 'Temperos e Condimentos',
            10 => 'Outros'
        ];
    }

    public static function nivelArr():array
    {
        return EntityDepartamento::nivelArr();
    }

    public static function medidaArr():array
    {
        return [
            1 => 'Kg',
            2 => 'gm',
            3 => 'Lt',
            4 => 'ml',
            5 => 'Caixa',
            6 => 'Fardo',
            7 => 'Pacote',
            8 => 'Und'
        ];
    }
}