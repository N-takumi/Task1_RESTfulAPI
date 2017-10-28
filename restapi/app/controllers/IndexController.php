<?php

class IndexController extends ControllerBase
{

  //コントローラでGETやPOSTのパラメータを受け取り、モデルの関数を呼んでレスポンスを用意して返す処理などを書きます。

    public function indexAction()
    {

    }

    //データの取得 全件取得
    public function getAllAction()
    {
      echo'全件取得';

    }

    public function getPieceAction()
    {
      echo'個別取得';
      $id = $this->dispatcher->getParam('int');
      echo($id);
    }

    public function searchAction()
    {
      echo'検索処理';
      $name = $this->dispatcher->getParam('name');
      echo($name);
    }

    //データの挿入
    public function addAction()
    {

    }
    //データの変更(更新)
    public function updateAction()
    {

    }

    //データの削除
    public function deleteAction()
    {
      
    }








}
