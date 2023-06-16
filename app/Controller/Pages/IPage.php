<?php
namespace Octus\App\Controller\Pages;


use Octus\App\Model\EntityCompany;

interface IPage
{
    /**
     * Method return credentials to grant access page
     *
     * @return array
     */
    public function getCredentials():array;

    /**
     * Method return infos system name and description in database
     *
     * @return EntityCompany|null
     */
    public function getCompany():EntityCompany;

    /**
     * Method return render html with page request by route url
     *
     * @param string $title
     * @param string $content
     * @param array $params
     * @param bool $secutiry
     * @param bool $hshow
     * @param bool $fshow
     * @return string
     */
    public function getPage(string $title, string $content, array $params = [], bool $hshow = true, bool $fshow = true):string;
}