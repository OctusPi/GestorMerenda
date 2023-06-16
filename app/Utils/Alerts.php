<?php
namespace Octus\App\Utils;

use Octus\App\Model\Entity;
use Octus\App\Model\EntityUsuario;

class Alerts
{
    const STATUS_ERROR   = 'error';
    const STATUS_OK      = 'success';
    const STATUS_WARNING = 'warning';
    const STATUS_FAIL    = 'rededown';
    const STATUS_FORM    = 'mandatory';
    const STATUS_SEACH   = 'leastone';
    const STATUS_DUPLI   = 'duplici';
    const STATUS_NFOUND  = 'notfound';

    /**
     * json_encode enconder msg alert in two objects status, entity and register log action
     *
     * @param string $code
     * @param string|null $details
     * @param Entity|null $entity
     * @return string
     */
    public static function notify(string $code, ?string $details = null, ?string $view = null, ?int $id = null, ?EntityUsuario $usuario = null):string
    {
        //define message alert and entity feed form callback
        $status = ['code' => $code, 'details' => $details];
        Logs::writeLog($code.': '.$details, $usuario);

        return json_encode([
            'status' => $status,
            'id'     => $id,
            'view'   => $view != null ? json_decode($view)->{'view'} : null
        ]);
    }
}