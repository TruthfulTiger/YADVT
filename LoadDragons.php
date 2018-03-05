<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 16/02/2018
 * Time: 14:28
 */

namespace DesignPatterns\FactoryPattern;

require_once 'LoadAllDragons.php';

class LoadDragons
{
    private $output;

    public function setOutput(ILoadDragons $dragons)
    {
        $this->output = $dragons;
    }

    public function loadOutput()
    {
        return $this->output->loadDragons();
    }
}
