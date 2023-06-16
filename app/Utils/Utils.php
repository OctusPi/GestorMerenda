<?php
namespace Octus\App\Utils;
use Octus\App\Model\Entity;

class Utils
{
    /**
     * Method checks if array is nul and if key existis in array en return value of key
     *
     * @param int|string $key
     * @param array|null $dados
     * @return mixed
     */
    public static function at(null|int|string $key, ?array $dados):mixed
    {
        if($key != null && $dados != null){
            return array_key_exists($key, $dados) ? $dados[$key] : null;
        }else{
            return null;
        }
    }

    /**
     * Method checks if object Entity was defined and rescue attribute to return case not exists return null
     *
     * @param string|null $attr
     * @param Entity|null $object
     * @return mixed
     */
    public static function atob(?string $attr, ?Entity $object):mixed
    {
        return $object != null ? $object->getAttr($attr) : null;
    }

    /**
     * Remove unnecessary elements in array
     *
     * @param array|null $dirty
     * @param array|null $fkeys
     * @return array
     */
    public static function filter(?array $dirty, ?array $fkeys = null):array
    {
        $filter = [];

        if($dirty != null){
            foreach ($dirty as $key => $value) {
                if($fkeys == null){
                    $filter[$key] = $value;
                }else{
                    if(in_array($key, $fkeys)){
                        $filter[$key] = $value;
                    }
                }
            }
        }

        return $filter;
    }

    /**
     * conver async search string url in array and remove unnecessary elements
     *
     * @param string|null $search
     * @param array $fields
     * @return array
     */
    public static function urlsearch(?string $search, array $fields):array
    {
        $arrsearch = [];
            
            if($search != null){
                $temp = explode('&', $search);
                foreach($temp as $item){
                    $tempitem = explode('=', $item);
                    $arrsearch[$tempitem[0]] = $tempitem[1];
                }
            }

            return self::filter($arrsearch, $fields);
    }

    /**
     * Method conevert sting to array using different pattern separator
     * @param string|null $data
     * @param string $pattern
     * @return array
     */
    public static function toArray(?string $data, string $pattern = ','):array
    {
        return $data != null ? explode($pattern, $data) : [];
    }

    /**
     * Method conevert array to string using different pattern separator
     * @param array|null $data
     * @param string $pattern
     * @return array
     */
    public static function toString(?array $data, string $pattern = ','):?string
    {
        return $data != null ? implode($pattern, $data) : null;
    }

    /**
     * Create a randon code to identify unique
     *
     * @return string
     */
    public static function code(int $size = 12):string
    {
        $letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
        $digits  = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        $code = '';

        for ($i = 0; $i < $size; $i++) {
            $matriz = ($i > 0 && $i % rand(2, 5) === 0) ? $digits : $letters;
            $key    = rand(0, count($matriz)-1);
            $code  .= $matriz[$key];
        }

        return $code;
    }
}