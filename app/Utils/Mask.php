<?php
namespace Octus\App\Utils;

class Mask
{

    /**
     * Create path CPF to save in DB or View in Page
     *
     * @param string|null $cpf
     * @return string
     */
    public static function maskCPF(?string $cpf):string
    {
        $maskCPF  = '';
        if($cpf != null){
            $maskCPF = str_replace(['.', '-'], '', $cpf);
            $maskCPF = str_pad($maskCPF,11,'0', STR_PAD_LEFT);
            $maskCPF = substr($maskCPF, 0,11);
            $maskCPF = substr_replace($maskCPF, '.', 3, 0);
            $maskCPF = substr_replace($maskCPF, '.', 7, 0);
            $maskCPF = substr_replace($maskCPF, '-', 11, 0);
            
        }
        return $maskCPF;
        
    }

    public static function maskPhone(?string $phone):?string
    {
        return $phone != null ? substr($phone,0,15) : ''; 
    }
    
}