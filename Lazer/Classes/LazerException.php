<?php

  namespace Lazer\Classes;

if( ! defined('BASEPATH')) exit('No direct script access allowed');

 /**
  * Exception extend
  *
  * @category Exceptions
  * @author Grzegorz Kuźnik
  * @copyright (c) 2013, Grzegorz Kuźnik
  */
 class LazerException extends \Exception {

     public function __construct($message, $code = 0)
     {
         parent::__construct($message, $code);
     }

     public function __toString()
     {
         return $this->message;
     }

 }

 