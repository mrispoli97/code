<?php

class helper{

  public function slugify($word){

    $word = str_replace(array('ä', 'ö', 'ü', 'ß'), array('ae', 'oe', 'ue', 'ss'), mb_strtolower($word));

    preg_match("/^[a-zA-Z0-9 ]+$/", $word);

    $slug = str_replace(' ', '-', $word);

    return $slug;

  }

  public function pathify($word){

    $slug = $this -> slugify($word);

    $path = getenv('JSON_PATH') . '/' . $slug . '.json';

    return $path;

  }

}


?>
