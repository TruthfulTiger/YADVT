<?php
namespace DesignPatterns\ObserverPattern;

require_once 'IObservable.php';

interface IObserver {
    public function Update(IObservable $observable);

}