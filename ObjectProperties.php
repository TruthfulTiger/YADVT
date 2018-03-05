<?php
namespace Main;

class ObjectProperties { // You know this one already - thanks for the idea :)

    // Methods for creating property-like functions in PHP

    // To simulate get and set properties, we use interceptor methods

    // Get method
    public function __get($property) {
        $method = "Get{$property}"; // Find method called Getxxx
        if(method_exists($this, $method)) { // If method Getxxx exists, run code
            return $this->$method(); // Call Getxxx
        }
        return; // Return undefined otherwise
    }

    // Set method
    public function __set($property, $value) {
        $method = "Set{$property}";
        if(method_exists($this, $method)) { // If method Setxxx exists, run code
            $this->$method($value); // Call Setxxx and pass it $value
        }
        return;
    }
}

?>