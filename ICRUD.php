<?php
// Inspired by: PHP Hacks by Jack D. Herrington - turned his CRUD functions hack into an interface

namespace DesignPatterns\FactoryPattern;


interface ICRUD
{
    public function load($id);

    public function insertRecord();

    public function updateRecord($id);

    public function deleteRecord($id);

}