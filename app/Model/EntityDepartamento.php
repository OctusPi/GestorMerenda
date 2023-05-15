<?php
namespace Octus\App\Model;

use Octus\App\Data\ConnDB;
use Octus\App\Model\Entity;

class EntityDepartamento extends Entity
{
    protected int $tipo;
    protected string $departamento;
    protected ?string $inep;
    protected int|EntitySecretaria $secretaria;
    protected ?string $endereco;
    protected ?string $telefone;
    protected ?string $email;
    protected int $qtinfantil;
    protected int $qtfund1;
    protected int $qtfund2;
    protected int $qtmedio;
    protected int $qteja;
    protected ?string $dtcreate;
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
        return ConnDB::TAB_DEPTS;
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

    public static function tipoArr():array
    {
        return[
            1 => 'Escola',
            2 => 'Creche',
            3 => 'Departamento'
        ];
    }

}