<?php

class buildData{

  private function getParams(){

    // $param = '';
    //
    // if($_SERVER['REQUEST_URI']){
    //
    //   $params = explode('/', urldecode($_SERVER['REQUEST_URI']));
    //
    //   if(count($params) > 1){
    //     $param = $params[1];
    //   }
    //
    // }

    //$param = 'elektrokamin-anthrazit';
    $param = 'elektrokamin-anthrazit-new';

    return $param;

  }

  private function getFile($path){

    if(file_exists($path)){

      $dataJSON = file_get_contents($path);
      $data = json_decode($dataJSON, true);

      $data['brands'] = array_unique(array_column($data['products']['active'], 'brand'));

    } else {

      $data = '';

    }

    return $data;

  }

  public function main(){

    $param = $this -> getParams();

    if($param){

      $path = getenv('JSON_PATH') . '/' . $param . '.json';

      if(file_exists($path)){
        $file = $this -> getFile($path);
        $data = array(
          'type' => 'keyword',
          'data' => $file
        );
      }
    }

    return $data;

  }

}


?>
