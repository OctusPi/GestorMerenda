<?php
namespace Octus\App\Model;

use Octus\App\Data\ConnDB;
use Octus\App\Model\Entity;

class EntityUnidade extends Entity
{
    protected int $tipo;
    protected string $unidade;
    protected ?string $inep;
    protected int|EntitySecretaria $secretaria;
    protected string $alunado;
    protected ?string $endereco;
    protected ?string $telefone;
    protected ?string $email;
    protected ?string $dtcreate;
    protected ?string $dtupdate;
    protected int $agente;

    public function __construct()
    {
        parent::__construct();
    }

    public function setAlunado(mixed $alunado):void
    {
        $this->alunado = is_array($alunado) ? serialize($alunado) : $alunado;
    }

    public function getAlunado():array
    {
        $serial = unserialize($this->alunado);
        return is_array($serial) ? $serial : [];
    }

    /**
     * Return name of table in database reference entity
     * @override
     * @return string|null
     */
    public function getDataTableEntity(): ?string 
    {
        return ConnDB::TAB_UNIDS;
    }

    /**
     * Method return array with exclusive properties to entity
     *
     * @return array
     */
    public function getExclusivePropsClass():array
    {
        return ['unidade', 'secretaria'];
    }

    /**
     * Return array with mandatory propertys of class
     *
     * @return array
     */
    public static function getObrPropsClass():array
    {
        return ['tipo', 'unidade', 'secretaria'];
    }

    public static function tipoArr():array
    {
        return[
            1 => 'Escola',
            2 => 'Creche',
            3 => 'Núcleo',
            4 => 'Departamento'
        ];
    }

    public static function nivelArr():array
    {
        return [
            1 => 'Creche | Berçário',
            2 => 'Pre Escola',
            3 => 'Fundamental | EJA',
            4 => 'Integral | Contraturno',
        ];
    }

}