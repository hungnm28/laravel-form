<?php

namespace Hungnm28\LaravelForm\Traits;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait WithLaravelFormTrait
{
    use AuthorizesRequests;
    public $record_id;
    public $done = 0;

    public function addItem($name, $param)
    {
        $param = trim($param);
        if ($param == '') return false;
        if (isset($this->$name)) {
            $data = $this->$name;
            Arr::add($data, $name, $param);
            $data[] = $param;
            $this->$name = array_keys(array_flip($data));
        } else {
            if (Str::contains($name, ".")) {
                $this->addDotItem($name, $param);
            }
        }
    }

    private function addDotItem($name, $param)
    {
        $arrDots = explode(".", $name);
        $val = $arrDots[0];
        $key = Str::after($name, $val . ".");
        if (isset($this->$val)) {
            $data = data_get($this->$val, $key);
            $data[] = $param;
            data_set($this->$val, $key, array_keys(array_flip($data)));
        }
    }
    public function removeItem($val, $k)
    {
        if (isset($this->$val) && isset($this->$val[$k])) {
            unset($this->$val[$k]);
            $this->$val = array_values($this->$val);
        } else {

            $this->removeDotItem($val, $k);
        }

    }
    private function removeDotItem($name, $k)
    {
        $arrDots = explode(".", $name);
        $val = $arrDots[0];
        $key = Str::after($name, $val . ".");
        if (isset($this->$val)) {
            $data = data_get($this->$val, $key);
            if (isset($data[$k])) {
                unset($data[$k]);
                $data = array_keys(array_flip($data));
                data_set($this->$val, $key, $data);
            }
        }
    }

    public function redirectForm($route, $id, $params = [])
    {
        switch ($this->done) {
            case 0:
                $this->redirect(route("$route", $params));
                break;
            case 1:
                $this->redirect(route("$route.create", $params));
                break;
            case 2:
                $params["record_id"] = $id;
                $this->redirect(route("$route.show", $params));
                break;
            case 3:
                $params["record_id"] = $id;
                $this->redirect(route("$route.edit", $params));
                break;
            default:
                $this->redirect(route($route));
        }
    }

    public function postSort($name)
    {
        if (isset($this->$name)) {
            $val = $this->$name + 1;
            if ($val > 2) $val = 0;
            $this->$name = $val;
        }
    }

    public function resetForm()
    {
        $this->redirect(request()->header('Referer'));
    }
}
