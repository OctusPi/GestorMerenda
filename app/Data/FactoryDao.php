<?php
namespace Octus\App\Data;

use Octus\App\Model\EntityDepartamento;
use Octus\App\Model\EntityEntrada;
use Octus\App\Model\EntityEstoque;
use Octus\App\Model\EntityHistory;
use Octus\App\Model\EntityInsumo;
use Octus\App\Model\EntityProducao;
use Octus\App\Model\EntitySaida;
use Octus\App\Model\EntitySecretaria;
use Octus\App\Model\EntityUnidade;
use Octus\App\Model\EntityUsuario;
use Octus\App\Model\EntityCompany;
use Octus\App\Data\ImpDao;

class FactoryDao
{
    /**
     * Method return new instance of implementation Data Access Object using Entity Info
     *
     * @return ImpDao
     */
    public function daoCompany(?EntityCompany $entity = null):ImpDao
    {
        return new ImpDao($entity != null ? $entity : new EntityCompany());
    }

    /**
     * Method return new instance of implementation Data Access Object using Entity Usuario
     *
     * @return ImpDao
     */
    public function daoUsuario(?EntityUsuario $entity = null):ImpDao
    {
        return new ImpDao($entity != null ? $entity : new EntityUsuario());
    }

    /**
     * Method return new instance of implementation Data Access Object using Entity Contrato
     *
     * @return ImpDao
     */
    public function daoUnidade(?EntityUnidade $entity = null):ImpDao
    {
        return new ImpDao($entity != null ? $entity : new EntityUnidade());
    }

    /**
     * Method return new instance of implementation Data Access Object using Entity Contrato
     *
     * @return ImpDao
     */
    public function daoEntrada(?EntityEntrada $entity = null):ImpDao
    {
        return new ImpDao($entity != null ? $entity : new EntityEntrada());
    }

    /**
     * Method return new instance of implementation Data Access Object using Entity Departamento
     *
     * @return ImpDao
     */
    public function daoEstoque(?EntityEstoque $entity = null):ImpDao
    {
        return new ImpDao($entity != null ? $entity : new EntityEstoque());
    }

    /**
     * Method return new instance of implementation Data Access Object using Entity Fornecedor
     *
     * @return ImpDao
     */
    public function daoHistory(?EntityHistory $entity = null):ImpDao
    {
        return new ImpDao($entity != null ? $entity : new EntityHistory());
    }

    /**
     * Method return new instance of implementation Data Access Object using Entity Lote
     *
     * @return ImpDao
     */
    public function daoInsumo(?EntityInsumo $entity = null):ImpDao
    {
        return new ImpDao($entity != null ? $entity : new EntityInsumo());
    }

    /**
     * Method return new instance of implementation Data Access Object using Entity Saida
     *
     * @return ImpDao
     */
    public function daoProducao(?EntityProducao $entity = null):ImpDao
    {
        return new ImpDao($entity != null ? $entity : new EntityProducao());
    }

    /**
     * Method return new instance of implementation Data Access Object using Entity Saida
     *
     * @return ImpDao
     */
    public function daoSaida(?EntitySaida $entity = null):ImpDao
    {
        return new ImpDao($entity != null ? $entity : new EntitySaida());
    }

    /**
     * Method return new instance of implementation Data Access Object using Entity Saida
     *
     * @return ImpDao
     */
    public function daoSecretaria(?EntitySecretaria $entity = null):ImpDao
    {
        return new ImpDao($entity != null ? $entity : new EntitySecretaria());
    }
}