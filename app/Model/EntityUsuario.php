<?php
namespace Octus\App\Model;

use Octus\App\Controller\Components\BuildNav;
use Octus\App\Data\ConnDB;
use Octus\App\Model\Entity;
use Octus\App\Utils\Utils;

class EntityUsuario extends Entity
{

    //constantes
    const PRF_ADMIN   = 1;
    const PRF_GESTOR  = 2;
    const PRF_DEPTO   = 3;

    const NVL_INICIAL       = 0;
    const NVL_PRODUCAO      = 1;
    const NVL_SECRETARIAS   = 2;
    const NVL_DEPARTAMENTOS = 3;
    const NVL_CALENDARIO    = 4;
    const NVL_INSUMOS       = 5;
    const NVL_ESTOQUE       = 6;
    const NVL_ENTRADAS      = 7;
    const NVL_SAIDAS        = 8;
    const NVL_RPORTS        = 9;
    const NVL_BIGBOSS       = 10;

    //propertys
    protected string  $nome;
    protected string  $cpf;
    protected string  $email;
    protected ?string $telefone;
    protected string  $uid;
    protected string  $pid;
    protected int     $perfil;
    protected string  $nivel;
    protected ?int    $secretaria;
    protected ?string $departamentos;
    protected int     $status;
    protected ?string $lastlogin;
    protected ?string $nowlogin;
    protected int     $passchange;
    protected ?string $dtcreate;
    protected ?string $dtupdate;
    protected int $agente;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Method return credentials to level access witn profile and level of access user
     *
     * @return array
     */
    public function getCredentials():array
    {
        return[
            'profile'    => $this->perfil,
            'level'      => Utils::toArray($this->nivel),
            'secretaria' => $this->secretaria,
            'deptos'     => Utils::toArray($this->departamentos),
        ];
    }

    /**
     * set property nivel value by perfil
     *
     * @param int $perfil
     * @return void
     */
    public function buildnivel(int $perfil):void
    {
        $this->nivel = match($perfil){
            self::PRF_ADMIN   => implode(',', array_keys(self::getNivelArr())),
            self::PRF_GESTOR  => '0,3,4,5,6,7,8,9,10',
            self::PRF_DEPTO   => '0,1,4,6,7,9',
            default => '0'
        };
    }

    public function buildnav():array
    {
        return match($this->perfil)
        {
            self::PRF_ADMIN => [
                ['producao'],
                ['secretarias', 'departamentos', 'calendario'],
                ['insumos', 'estoque', 'entradas', 'saidas'],
                ['relatorios']
            ],

            self::PRF_GESTOR => [
                ['departamentos', 'calendario'],
                ['insumos', 'estoque', 'entradas', 'saidas'],
                ['relatorios']
            ],

            self::PRF_DEPTO => [
                ['producao'],
                ['calendario'],
                ['estoque', 'entradas'],
                ['relatorios']
            ],

            default => []
        };

    }


    /**
     * Return name of table in database reference entity
     * @override
     * @return string|null
     */
    public function getDataTableEntity(): ?string 
    {
        return ConnDB::TAB_USER;
    }

    /**
     * Method return array with exclusive properties to entity
     *
     * @return array
     */
    public function getExclusivePropsClass():array
    {
        return ['cpf'];
    }

    /**
     * Return array with mandatory propertys of class
     *
     * @return array
     */
    public static function getObrPropsClass():array
    {
        return ['nome', 'cpf', 'email', 'perfil', 'status'];
    }

    /**
     * Return array with status
     *
     * @return array
     */
    public static function getStatusArr():array
    {
        return [
            1 => 'Ativo',
            2 => 'Bloqueado'
        ];
    }

    /**
     * Return array with status colors
     *
     * @return array
     */
    public static function getStatusColorArr():array
    {
        return [
            1 => 'text-success',
            2 => 'text-danger'
        ];
    }

    /**
     * Return array with perfis availables
     *
     * @return array
     */
    public static function getPerfilArr():array
    {
        return [
            self::PRF_ADMIN  => 'Administrador Sistema',
            self::PRF_GESTOR => 'Gestor Municipal',
            self::PRF_DEPTO  => 'Coordenador|Diretor Escolar'
        ];
    }

    /**
     * Return array with niveis availables
     *
     * @return array
     */
    public static function getNivelArr():array
    {
        return [
            self::NVL_INICIAL       => 'Acesso Inicial',
            self::NVL_PRODUCAO      => 'Registro de Produção',
            self::NVL_SECRETARIAS   => 'Gestão de Secretarias',
            self::NVL_DEPARTAMENTOS => 'Gestão de Departamentos',
            self::NVL_CALENDARIO    => 'Gestão Calendário Escolar',
            self::NVL_INSUMOS       => 'Registro de Insumos',
            self::NVL_ESTOQUE       => 'Gestão de Estoque',
            self::NVL_ENTRADAS      => 'Registro de Entrada de Insumos',
            self::NVL_SAIDAS        => 'Registro de Saídas de Insumos',
            self::NVL_RPORTS        => 'Emissão de Relatórios',
            self::NVL_BIGBOSS       => 'Administração Total',
            
        ];
    }
}