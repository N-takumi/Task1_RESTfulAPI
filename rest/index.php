<?php

use Phalcon\Loader;//ローダの使用
use Phalcon\Http\Response;
use Phalcon\Mvc\Micro;//マイクロアプリケーションの使用(apiに向いている)
use Phalcon\Di\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;

// Use Loader() to autoload our model
//ローダーの定義
$loader = new Loader();

$loader->registerNamespaces(
    [
        'Store\Toys' => __DIR__ . '/models/',
    ]
);
$loader->register();


// $diの構築
$di = new FactoryDefault();

// Set up the database service
$di->set(
    'db',
    function () {
        return new PdoMysql(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => '',
                'dbname'   => 'shop',//shopに変更
            ]
        );
    }
);


// マイクロアプリケーションの開始
$app = new Micro($di);

// Define the routes here
//以下でルートを定義する
//各ルートはhttpメソッドと同じ名前で定義される
//最初のパラメータとしてルートパターンを渡し、その後にハンドラが続く

//データの取得 全件取得
$app->get(
    '/api/products',
    function () use ($app) {
        //PHQLを使って実行
        $phql = 'SELECT * FROM Store\Toys\Products ORDER BY id';//id順に取得

        $products = $app->modelsManager->executeQuery($phql);//実行結果を格納

        $data = [];//レスポンスデータの格納 配列

        foreach ($products as $product) {
            $data[] = [
                'id'   => $product->id,
                'name' => $product->name,
                'price'=> $product->price,
            ];
        }

        echo json_encode($data);
    }
);


//個別取得
$app->get(
    '/api/products/{id:[0-9]+}',
    function ($id) use ($app) {
        $phql = 'SELECT * FROM Store\Toys\Products WHERE id = :id:';

        $product = $app->modelsManager->executeQuery(
            $phql,
            [
                'id' => $id,
            ]
        )->getFirst();//結果の最初のレコードを取得

        // Create a response
        $response = new Response();

        if ($product === false) {
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
                        'id'   => $product->id,
                        'name' => $product->name
                    ]
                ]
            );
        }
        return $response;
    }
);


//検索 //部分一致
$app->get(
    '/api/products/search/{name}',
    function ($name) use ($app) {
        $phql = 'SELECT * FROM Store\Toys\Products WHERE name LIKE :name: ORDER BY name';//後でマッピングする

        $products = $app->modelsManager->executeQuery(
            $phql,
            [
                'name' => '%' . $name . '%'
            ]
        );

        $data = [];//レスポンスデータの格納 配列

        foreach ($products as $product) {
            $data[] = [
                'id'   => $product->id,
                'name' => $product->name,
                'description'=> $product->description,
                'price'=> $product->price,
            ];
        }

        //検索結果が見つからない時のレスポンスを準備する必要がある

        echo json_encode($data);
    }
);



// Adds a new product
//データの挿入
$app->post(
    '/api/products',
    function () use ($app) {
            $product = $app->request->getJsonRawBody();//デコードされたJSON HTTP生のリクエストボディを取得する

            $phql = 'INSERT INTO Store\Toys\Products (name, description, price) VALUES (:name:, :description:, :price:)';

            $status = $app->modelsManager->executeQuery(
                $phql,
                [
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                ]
            );

            //レスポンスの作成
            $response = new Response();

            // Check if the insertion was successful
            if ($status->success() === true) {
                // Change the HTTP status
                $response->setStatusCode(201, 'Created');

                $product->id = $status->getModel()->id;//IDの割り当て

                $response->setJsonContent(
                    [
                        'status' => 'OK',
                        'data'   => $product,
                    ]
                );
            } else {
                // Change the HTTP status
                $response->setStatusCode(409, 'Conflict');

                // Send errors to the client
                $errors = [];

                foreach ($status->getMessages() as $message) {
                    $errors[] = $message->getMessage();
                }

                $response->setJsonContent(
                    [
                        'status'   => 'ERROR',
                        'messages' => $errors,
                    ]
                );
            }

            return $response;
        }
);


// Updates products based on primary key
//データの変更(更新)
$app->put(
    '/api/products/{id:[0-9]+}',
    function ($id) use ($app) {
        $product = $app->request->getJsonRawBody();//デコードされたJSON HTTP生のリクエストボディを取得する

        $phql = 'UPDATE Store\Toys\Products SET name = :name:, description = :description:, price = :price: WHERE id = :id:';//IDで指定した商品の変更

        $status = $app->modelsManager->executeQuery(
            $phql,
            [
                'id'   => $id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
            ]
        );

        //レスポンスの作成
        $response = new Response();

        // Check if the insertion was successful
        if ($status->success() === true) {
            $response->setJsonContent(
                [
                    'status' => 'OK'
                ]
            );
        } else {
            // Change the HTTP status
            $response->setStatusCode(409, 'Conflict');

            $errors = [];

            foreach ($status->getMessages() as $message) {
                $errors[] = $message->getMessage();
            }

            $response->setJsonContent(
                [
                    'status'   => 'ERROR',
                    'messages' => $errors,
                ]
            );
        }

        return $response;
    }
);




// Deletes products based on primary key
//データの削除
$app->delete(
    '/api/products/{id:[0-9]+}',
    function ($id) use ($app) {
        $phql = 'DELETE FROM Store\Toys\Products WHERE id=:id:';//ID指定して削除する

        $status = $app->modelsManager->executeQuery(
            $phql,
            [
                'id' => $id,
            ]
        );

        // Create a response
        $response = new Response();

        if ($status->success() === true) {
            $response->setJsonContent(
                [
                    'status' => 'OK'
                ]
            );
        } else {
            // Change the HTTP status
            $response->setStatusCode(409, 'Conflict');

            $errors = [];

            foreach ($status->getMessages() as $message) {
                $errors[] = $message->getMessage();
            }

            $response->setJsonContent(
                [
                    'status'   => 'ERROR',
                    'messages' => $errors,
                ]
            );
        }

        return $response;
    }
);


$app->handle();
