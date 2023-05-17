<?php
namespace Octus\App\Data;

use PDO;
use Octus\App\Utils\Logs;
use PDOException;

class ConnDB
{
    //defines tables in database
    const TAB_COMPN = 'tabgm_company';
    const TAB_USER  = 'tabgm_usuarios';
    const TAB_SECTR = 'tabgm_secretarias';
    const TAB_DEPTS = 'tabgm_departamentos';
    const TAB_INSMS = 'tabgm_insumos';
    const TAB_ESTOQ = 'tabgm_estoques';
    const TAB_ENTRD = 'tabgm_entradas';
    const TAB_SAIDS = 'tabgm_saidas';
    const TAB_HISTR = 'tabgm_historys';
    const TAB_PRODU = 'tabgm_producao';
    const TAB_CALEND = 'tabgm_calendario';


    //defines params to create local connection
    private static string $conntype = 'mysql';
    private static string $connhost = 'database';
    private static string $connport = '3306';
    private static string $conndata = 'data_altfolha';
    private static string $connuser = 'root';
    private static string $connpass = 'tiger';


    /**
     * PDO instace connectio DB
     *
     * @var PDO|null
     */
    private static ?PDO $conn = null;

    /**
     * Return instace PDO conn
     *
     * @return PDO
     */
    public static function openConn(): PDO
    {
        if (self::$conn == null) {
            try {
                self::$conn = new PDO(
                        self::$conntype . ':host=' . self::$connhost . ';port=' . self::$connport . ';dbname=' . self::$conndata,
                        self::$connuser,
                        self::$connpass
                );

            } catch (PDOException $e) {
                Logs::writeLog('Erro: ' . $e->getMessage());
                die('Falha ao conectar com banco de dados...');
            }
        }

        return self::$conn;
    }

    /**
     * Close connectio unset PDO instance
     *
     * @return void
     */
    public static function closeConn(): void
    {
        if (self::$conn != null) {
            self::$conn = null;
        }
    }
}