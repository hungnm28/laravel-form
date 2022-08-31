<?php

namespace Hungnm28\LaravelForm;

use Hungnm28\LaravelForm\Traits\SingletonTrait;

class LaravelForm
{
    use SingletonTrait;
    const VERSION = "1.0.0";

    private $breadcrumb = [];
    private $title ="";

    public function getVersion()
    {
        return self::VERSION;
    }

    public function getTitle(){
        return $this->title;
    }

    public function setTitle($title){
        $this->title = $title;
    }

    public function getBreadcrumb()
    {
        return $this->breadcrumb;
    }


    public function pushBreadCrumb($url, $name)
    {
        $this->breadcrumb[] = (object)["url" => $url, "name" => $name];
    }

}
