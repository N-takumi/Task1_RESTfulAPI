<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Message;
//use Phalcon\Mvc\Model\Validator\Uniqueness;
//use Phalcon\Mvc\Model\Validator\InclusionIn;

class Products extends Model
{
    public function validation()//データの妥当性を高めるための機能
    {

      /*
      //
        // Type must be: droid, mechanical or virtual
        $this->validate(
            new InclusionIn(
                [
                    'field'  => 'type',
                    'domain' => ['droid','mechanical','virtual'],
                ]
            )
        );
      */

      /*
        // Robot name must be unique
        $this->validate(
            new Uniqueness(
                [
                    'field'   => 'name',
                    'message' => 'The robot name must be unique',
                ]
            )
        );
      */

        // price cannot be less than zero
        if ($this->price < 0) {
            $this->appendMessage(
                new Message('The price cannot be less than zero')
            );
        }

        // Check if any messages have been produced
        if ($this->validationHasFailed() === true) {
            return false;
        }
    }
}
