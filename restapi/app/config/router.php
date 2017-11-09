<?php
use Phalcon\Mvc\Router;

$router = $di->getRouter();

// Define your routes here

//データの取得 全件取得
$router->addGet(
    '/products',
    [
        'controller' => 'index',
        'action'     => 'getAll',
    ]
);

//個別取得
$router->addGet(
    '/products/:int',
    [
        'controller' => 'index',
        'action'     => 'getPiece',
        'int'        =>1,
    ]
);

//検索 //部分一致
$router->addGet(
    '/products/search/{name}',
    [
        'controller' => 'index',
        'action'     => 'search',
    ]
);

//データの挿入
$router->addPost(
    '/products',
    [
        'controller' => 'index',
        'action'     => 'add',
    ]
);

//データの変更(更新)
$router->addPut(
    '/products/:int',
    [
        'controller' => 'index',
        'action'     => 'update',
        'int'        =>1,
    ]
);

//データの削除
$router->addDelete(
    '/products/:int',
    [
        'controller' => 'index',
        'action'     => 'delete',
        'int'        =>1,
    ]
);





$router->handle();