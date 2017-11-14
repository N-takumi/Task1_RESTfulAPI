<?php
use Phalcon\Mvc\Controller;
use Store\Models\Products;
use Phalcon\Http\Response;
use Phalcon\Http\Request;
class ImgsController extends Controller
{
    public function indexAction()
    {

    }


        //画像保存
        public function uploadImgAction()
        {
          $response = new Response();
            // Check if the user has uploaded files
          if ($this->request->hasFiles())
          {
              $files = $this->request->getUploadedFiles();
              // Print the real file names and sizes
              foreach ($files as $file) {
                // Print file details
                echo $file->getName(), ' ', $file->getSize(), '\n';
                echo $file->getTempName();

                if($file->moveTo('./img/' . $file->getName()) === false)
                {
                  $response->setStatusCode(409, 'Conflict');
                }else{
                  $response->setStatusCode(201, 'Created');
                  $response->setJsonContent(
                    [
                      'status' => 'OK',
                      'imgUrl'   => 'http://localhost/restapi/products/img/'.$file->getName(),
                    ],JSON_UNESCAPED_UNICODE
                  );
                }

              }
          }else{
            $response->setStatusCode(400, 'Bad Request');
          }
            $response->send();
            //return $response;
        }



        //画像表示
        public function showImgAction()
        {
          $name = $this->dispatcher->getParam('name');
          echo'画像表示</br>';

          $response = new Response();

          if(file_exists('img/'.$name) === false)
          {
            $response->setStatusCode(404, 'NOT-FOUND');
            echo '画像なし</br>';
          }else{
            $response->setStatusCode(200, 'OK');
            echo '画像あり</br>';
          }
          $response->setContent($this->tag->image('img/'.$name));
          $response->send();
        }



}
