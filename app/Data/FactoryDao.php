<?php
namespace Octus\App\Data;

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
}