<?php

//namespace Store\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Message;
//use Phalcon\Mvc\Model\Validator\Uniqueness;
//use Phalcon\Mvc\Model\Validator\InclusionIn;

class Products extends Model
{

    public $id;
    public $name;
    public $description;
    public $price;

    public function getId()
    {
      return $this->id;
    }
    public function getName()
    {
    return $this->name;
    }

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


        //タイトルの文字数制限
        if(strlen($this->name) > 100){
          $this->appendMessage(
              new Message('商品タイトルは最大100文字までです。')
          );
        }

        //説明文の文字数制限
        if(strlen($this->description) > 500){
          $this->appendMessage(
              new Message('説明文は最大100文字までです。')
          );
        }


        //priceに0以下の数字を設定できないようにする
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
