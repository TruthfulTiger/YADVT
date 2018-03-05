<?php
namespace DesignPatterns\ObserverPattern;

require_once 'IObserver.php';

interface IObservable {
    public function Attach(IObserver $observer);
    public function Detach(IObserver $observer);
    public function Notify();
}