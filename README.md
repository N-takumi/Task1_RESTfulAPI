# RESTfulなAPI

・RESTfulな商品管理のAPI

## Requirements


・PHP      7.1.8  
・phalcon  3.2.0  
・XAMPP    macOS 7.1.8  
・MariaDB  10.1.26  


## Installation
### XAMPPのインストール
以下でそれぞれのOSにあったものをインストールする
https://www.apachefriends.org/download.html  

### phalconのインストール

#### brew  


    $ brew tap homebrew/homebrew-php  
    $ brew install php71-phalcon  


### phalcon-devtoolのインストール


    $ git clone git://github.com/phalcon/phalcon-devtools.git  

    $ cd phalcon-devtools/  
    $ . ./phalcon.sh  

    $ ln -s ~/phalcon-devtools/phalcon.php /usr/bin/phalcon  
    $ chmod ugo+x /usr/bin/phalcon  


### XAMPPにphalconを導入する場合(macOS)

以下のディレクトリ  
XAMPP/xamppfiles/lib/php/extensions/no-debug-non-zts-201xxxxx/ に  
/usr/local/Cellar/php71-phalcon/3.2.0/  
にあるphalcon.soをコピーする  

XAMPP/etc/php.ini に  
extension="phalcon.so"を追加  


## API仕様

以下に、商品の「登録/検索/変更/削除」におけるリクエストとレスポンスを示します。



### 商品の登録
リクエスト:POST  
example url  

    http://localhost/restapi/products
    '{"name":"鉛筆","description":"すごい","price":"120","imgFileName":"pencil.jpg"}'


レスポンス  
成功 > (201,created)  

    {"status":"OK","data":{"name":"鉛筆","description":"すごい","price":"120","imgFileName":"pencil.jpg"}}


失敗 > (400,Bad Request) Postデータがない　等  
      (409,Conflict)  挿入データの矛盾　等  

    {"status":"ERROR","messages":["{error message}"]}



### 商品の検索
リクエスト:GET  
example url  

    http://localhost/restapi/products/search/{word}  


レスポンス  
成功 > (200,OK) wordの文字とnameが一致するレコードのデータと画像表示のURLを返します



    {"status":"FOUND","data":{"id":"3","name":"鉛筆","description":"すごい","price":"120","imgFileName":"pencil.jpg"},
    "imgUrl":"http:\/\/localhost\/restapi\/products\/img\/pencil.jpg"}


失敗 > (404,NOT-FOUND)  

    {"status":"NOT-FOUND"}



### 商品の変更
リクエスト:PUT  
example url  

    http://localhost/restapi/products/{変更する商品のid}  

    {"name":"鉛筆","description":"HBの鉛筆","price":"110","imgFileName":"pencil.jpg"}


レスポンス  
成功 > (200,OK)

    {"status":"OK","data":{"name":"鉛筆","description":"HBの鉛筆","price":"110","imgFileName":"pencil.jpg"}}


失敗 > (404,NOT-FOUND)指定されたIDの商品が存在しない

    {"status":"NOT-FOUND"}

      (409,Conflict) 変更データの矛盾等

    {"status":"ERROR","messages":["{error message}"]}



### 商品の削除
リクエスト:DELETE  

example url  

    http://localhost/restapi/products/{削除する商品のid}  

レスポンス  
成功 > (200,OK)

    {"status":"DELETED","data":{"id":"3","name":"鉛筆","description":"HBの鉛筆","price":"110","imgFileName":"pencil.jpg"}}


失敗 > (404,NOT-FOUND)指定されたIDの商品が存在しない

    {"status":"NOT-FOUND"}

      (409,Conflict)

    {"status":"ERROR","messages":["{error message}"]}


### 商品画像のアップロード

  以下のURLにアクセスし、フォームにて画像ファイルを選択しアップロードを行います

    http://localhost/restapi/Imgs  

  ![画像アップロードページ](https://github.com/N-takumi/Task1_RESTfulAPI/blob/master/description_IMG/upload.png)


  アップロードが成功すれば、その画像を表示するためのURLが返されます
