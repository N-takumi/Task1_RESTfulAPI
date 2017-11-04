<?php
//use Store\Models\Products;
use Phalcon\Http\Response;
class IndexController extends ControllerBase
{

  //コントローラでGETやPOSTのパラメータを受け取り、モデルの関数を呼んでレスポンスを用意して返す処理などを書きます。

    public function indexAction()
    {


    }

    //データの取得 全件取得
    public function getAllAction()
    {

      $data = [];//レスポンスデータの格納 配列

      $result = Products::find(
        ['order' => 'id',]
      );

      foreach ($result as $product) {
        $data[] = [
          'id'   => $product->id,
          'name' => $product->name,
          'price'=> $product->price,
        ];
      }

      return json_encode($data,JSON_UNESCAPED_UNICODE);

    //  echo'全部で',($result->name),'つの商品があります。';
    }

    public function getPieceAction()
    {
      echo'個別取得';
      $id = $this->dispatcher->getParam('int');

      $result = Products::findFirst($id);

      $response = new Response();
      if ($result === false) {
          $response->setJsonContent(
            [
            'status' => 'NOT-FOUND'
            ]
          );
      } else {
          $response->setJsonContent(
            [
            'status' => 'FOUND',
            'data'   => [
                'id'   => $result->id,
                'name' => $result->name
              ]
            ]
          );
      }

      return $response;

    }

    public function searchAction()
    {
      echo'検索処理</br>';
      $name = $this->dispatcher->getParam('name');

      $result = Products::findFirstByName($name);

      if($result){
        $data[] = [
            'id'   => $result->id,
            'name' => $result->name,
            'description'=> $result->description,
            'price'=> $result->price,
        ];
        return json_encode($data,JSON_UNESCAPED_UNICODE);
      }else{
        echo 'NOT-FOUND';
      }

    }

    //データの挿入
    public function addAction()
    {
      echo'データの挿入';

    }
    //データの変更(更新)
    public function updateAction()
    {
      echo'データの変更';
      $id = $this->dispatcher->getParam('int');
      echo($id);
    }

    //データの削除
    public function deleteAction()
    {
      echo'データの削除';
      $id = $this->dispatcher->getParam('int');
      echo($id);
    }










}
