<?php
//use Store\Models\Products;
use Phalcon\Http\Response;
use Phalcon\Http\Request;
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
      $data = [];//レスポンスデータの格納 配列

      $products = Products::find(
        ['order' => 'id',]//id順で
      );

      $response = new Response();

      if ($products === false)
      {
          $response->setStatusCode(404, 'NOT-FOUND');
          $response->setJsonContent(
            [
            'status' => 'NOT-FOUND'
            ]
          );
      } else {
          foreach ($products as $product)
          {
                $data[] = [
                  'id'   => $product->id,
                  'name' => $product->name,
                  'price'=> $product->price,
                ];
          }
          $response->setJsonContent(
            [
            'status' => 'FOUND',
            'data'   => $data
            ],JSON_UNESCAPED_UNICODE
          );
      }
      return $response;
    }


    //データの個別取得(IDで指定)
    public function getPieceAction()
    {
      echo'個別取得';
      $id = $this->dispatcher->getParam('int');

      $products = Products::findFirst($id);

      $response = new Response();
      if ($products === false)
      {
          $response->setStatusCode(404, 'NOT-FOUND');
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
                'id'   => $products->id,
                'name' => $products->name
              ]
            ],JSON_UNESCAPED_UNICODE
          );
      }
      return $response;
    }

    public function searchAction()
    {
      echo'検索処理';
      $name = $this->dispatcher->getParam('name');

      $products = Products::findFirstByName($name);

      $response = new Response();

      if ($products === false)
      {
          $response->setStatusCode(404, 'NOT-FOUND');
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
                'id'   => $products->id,
                'name' => $products->name,
                'description'=> $products->description,
                'price'=> $products->price
              ]
            ],JSON_UNESCAPED_UNICODE
          );
      }
      return $response;
    }

    //データの挿入
    public function addAction()
    {
      echo'データの挿入</br>';


      if ($this->request->isPost()){
        $result = $this->request->getJsonRawBody();
        echo(var_dump($result));
        echo($result->name);

        $product = new Products();
        $product->name = $result->name;
        $product->description = $result->description;
        $product->price = $result->price;
        $product->save();

      }


    }
    //データの変更(更新)
    public function updateAction()
    {
      echo'データの変更';
      $id = $this->dispatcher->getParam('int');
      echo($id);

      $data = Products::findFirst($id);

        $result = $this->request->getJsonRawBody();
        echo(var_dump($result));
        echo($data->name);

        $data->name = $result->name;
        $data->description = $result->description;
        $data->price = $result->price;
        $data->update();

    }

    //データの削除
    public function deleteAction()
    {
      echo'データの削除';
      $id = $this->dispatcher->getParam('int');
      echo($id);

      $result = Products::findFirst($id);

      $result->delete();
    }










}
