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

###商品の登録
リクエスト:POST  

example url  

http://localhost/rest/api/products/  
'{"name":"鉛筆","description":"2Bの鉛筆","price":120}'  

レスポンス  
{"status":"OK","data":{"name":"鉛筆","description":"2Bの鉛筆","price":120,"id":"1"}}  


###商品の検索
リクエスト:GET  

example url  

http://localhost/rest/api/products/search/{word}  

レスポンス  
wordの文字をnameに含むデータを返す  
{"id":"1","name":"word","description":"example","price":"120"}  


###商品の変更
リクエスト:PUT  

example url  
http://localhost/rest/api/products/{変更する商品のid}  

'{"name":"鉛筆","description":"HBの鉛筆","price":110}'  

レスポンス  
{"status":"OK"}  


###商品の削除
リクエスト:DELETE  
  
example url  
http://localhost/rest/api/products/{削除する商品のid}  

レスポンス  
{"status":"OK"}  
