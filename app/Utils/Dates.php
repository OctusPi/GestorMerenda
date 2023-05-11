<?php
namespace Octus\App\Utils;
use DateTimeImmutable;

class Dates
{
    /**
     * Method return array months pt-br
     * @return string[]
     */
    public static function getMesesArr(): array
    {
        return [
            1=>'Janeiro',
            2=>'Fevereiro',
            3=>'Março',
            4=>'Abril',
            5=>'Maio',
            6=>'Junho',
            7=>'Julho',
            8=>'Agosto',
            9=>'Setembro',
            10=>'Outubro',
            11=>'Novembro',
            12=>'Dezembro'
        ];
    }

    /**
     * return long number time unix by dateUTC English format
     * @param $dataUtc
     * @return int
     */
    public static function getUnixByDate(?string $dataUtc): int
    {
        $data = new DateTimeImmutable($dataUtc??'now');
        return $data->getTimestamp();
    }

    /**
     * Method return date local Brazilian PT-BR
     * @return string
     */
    public static function getDateNow(): string
    {
        return date('d/m/Y');
    }

    /**
     * Method return date and time local Brazilian PT-BR
     * @return string
     */
    public static function getDateTimeNow(): string
    {
        return date('d/m/Y H:i:s');
    }

    /**
     * Method returns string extense date now local Brazilian PT-BR
     * @return string
     */
    public static function getExtDateNow(): string
    {
        return date('d').' de '.self::getMesesArr()[date('n')].' de '.date('Y');
    }

    /**
     * Method returns string extense date informated in local Brazilian PT-BR
     * @param $dataUtc //English format yyyy-mm-dd
     * @return string
     */
    public static function getExtDate(string $dataUtc): string
    {
        $data  = new DateTimeImmutable($dataUtc);
        $day   = $data->format('d');
        $mount = $data->format('n');
        $year  = $data->format('Y');

        return $day.' de '.self::getMesesArr()[$mount].' de '.$year;
    }

    /**
     * return mounth - year by utc date
     *
     * @param string|null $dataUtc
     * @return string|null
     */
    public static function getMonthYearByDate(?string $dataUtc): ?string
    {
        $data  = new DateTimeImmutable($dataUtc??'now');
        $mount = $data->format('m');
        $year  = $data->format('Y');

        return $mount.'/'.$year;
    }

    /**
     * Methor calc age in years
     * @param $dataNascimento UTC
     * @return int|string
     */
    public static function diffYears(?string $dtnasc): int
    {
        $nasc  = new DateTimeImmutable($dtnasc ?? 'now');
        $today = new DateTimeImmutable('now');
        $age   = $nasc->diff($today);
        
        return $age->y;
    }

    /**
     * Calcule diff in days in two dates UTC format
     * @param string $dtorigin
     * @param string $dttarget
     * @return string
     */
    public static function diffDays(string $dtorigin, string $dttarget):int
    {
        $origin = new DateTimeImmutable($dtorigin);
        $target = new DateTimeImmutable($dttarget);
        $interval = $origin->diff($target);

        return $interval->invert ? - (int)$interval->days : (int)$interval->days;
    }

    /**
     * Method formatter date UTC English to Brazilian PT-BR
     * @param $dataUtc
     * @return string|null
     */
    public static function fmttDateView(?string $dataUtc): ?string
    {
        $fmtt = null;
        if($dataUtc != null){
            $data = new DateTimeImmutable($dataUtc ?? 'now');
            $fmtt = $data->format('d/m/Y');
        }
        return $fmtt;
    }

    /**
     * Method formatter datetime UTC English to Brazilian PT-BR
     * @param $dataUtc
     * @return string|null
     */
    public static function fmttDateTimeView(?string $dataUtc):?string
    {
        $fmtt = null;
        if($dataUtc != null){
            $data = new DateTimeImmutable($dataUtc ?? 'now');
            $fmtt = $data->format('d/m/Y H:i:s');
        }
        return $fmtt;
    }

    /**
     * Method formatter date UTC Brazilian PT-BR to DataBase UTC English
     * @param $dataLocal
     * @return string|null
     */
    public static function fmttDateDB(?string $dataLocal):?string
    {
        $fmtt = null;
        if($dataLocal != null)
        {
            $data = new DateTimeImmutable(self::convetToUTC($dataLocal) ?? 'now');
            $fmtt = $data->format('Y-m-d');
        }
        return $fmtt;
    }

    /**
     * Method formatter datetime UTC Brazilian PT-BR to DataBase UTC English
     * @param $dataLocal
     * @return string|null
     */
    public static function fmttDateTimeDB($dataLocal): ?string
    {
        $fmtt = null;
        if($dataLocal != null)
        {
            $data = new DateTimeImmutable(self::convetToUTC($dataLocal) ?? 'now');
            $fmtt = $data->format('Y-m-d H:i:s');
        }
        return $fmtt;
    }

    /**
     * Check if date is valid in time world interval
     *
     * @param string|null $dataUtc
     * @return boolean
     */
    public static function validDate(?string $dataUtc):bool
    {

        if($dataUtc != null)
        {
            $mount = date('n', self::getUnixByDate($dataUtc));
            $day   = date('j', self::getUnixByDate($dataUtc));
            $year  = date('Y', self::getUnixByDate($dataUtc));

            return checkdate($mount, $day, $year);
        }
        
        return false;
    }

    /**
     * Return list years by year start
     *
     * @param integer $start
     * @return array
     */
    public static function listYears(int $start = 2010):array
    {
        $years = [];
        while($start <= date('Y')){
            $years[$start] = $start;
            $start++;
        }

        return $years;
    }

    /**
     * Convert date local pt-br dd/mm/yyy to UTC world yyyy-mm-dd
     *
     * @param string|null $localDate
     * @return string|null
     */
    private static function convetToUTC(?string $localDate):?string
    {
        $cdate = null;
        $ldate = explode('/', $localDate);

        if($localDate != null && count($ldate) == 3)
        {
            $cdate = implode('-', array_reverse($ldate));
        }

        return $cdate;
    }
}