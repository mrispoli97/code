<?php

class productCard{

  function __construct(){

    $config = parse_ini_file('theme/config/conf.ini', true);

    $this -> config = $config;

  }

  private function debug($pos, $data){

    $html = '<div class="tooltip">i<span class="tooltiptext">';
    $html .= 'asin: ' . $data['asin'] . '</br>';
    $html .= 'weight: ' . $data['weight'] . '</br>';
    $html .= 'dimension: ' . $data['dimension'] . '</br>';
    $html .= 'termScore: ' . $data['termScore'];
    $html .= '</span></div>';

    return $html;

  }

  private function xor_this($string, $key){
      $str_len = strlen($string);
      $key_len = strlen($key);

      for ($i = 0; $i < $str_len; $i++) {
          $string[$i] = $string[$i] ^ $key[$i % $key_len];
      }

      return $string;
  }

  private function hide_link($string){
      $pass = 'nvgl';

      $xor = $this -> xor_this($string, $pass);
      $utf8 = base64_encode($xor);

      return $utf8;
  }

  private function buildLink($data, $pos){

    $pos = $pos + 1;

    $link = 'https://www.amazon.de/dp/';
    $link .= $data['asin'] . '/?tag=netzshopping-21&ascsubtag=';
    $link .= round(microtime(true) * 1000) . '_' . rand(10000, 99999) . '_nesho';
    // $link .= '[subid]';
    $link .= '-000_000_000' . '-' . $data['asin'];
    $link .= '-' . $pos . '-[device]';
    $link .= '&SubscriptionId=AKIAJPM2CXTM3YV5OTEQ&linkCode=ogi';

    return $link;

  }

  private function dataelements($pos, $data){

    $discount = $data['oldPrice'] > 0 ? round(100 * $data['oldPrice'] / ($data['oldPrice'] + $data['price'])) : 0;
    $link = $this -> buildLink($data, $pos);

    $html = 'data-relevance="' . $pos . '" ';
    $html .= 'data-id="' . $data['asin'] . '"';
    $html .= 'data-brand="' . $data['brand'] . '"';
    $html .= 'data-price="' . $data['price'] . '" ';
    $html .= 'data-discout="' . $discount . '" ';
    $html .= 'data-type="" ';
    $html .= 'data-target="' . $this -> hide_link($link) . '" ';

    return $html;

  }

  private function badge($pos, $data, $quick = 0){

    $config = $this -> config;

    $html = '';

    if($pos == 0 && $quick == 0){

      $html .= '<div class="badge fireBadge">';

      $html .= 'Beste Wahl';

      $html .= '</div>';

    } elseif($pos == 2 && $quick == 0){

          $html .= '<div class="badge fireBadge">';

          $html .= 'Unsere Empfehlung';

          $html .= '</div>';

        }
    else {

      if(isset($data['oldPrice']) && $data['oldPrice']){

        $html .= '<div class="badge savingsBadge">';

        $html .= round(100 * $data['oldPrice'] / ($data['oldPrice'] + $data['price']));

        $html .= $config['numbers']['savingsText'];

        $html .= '</div>';

      }

    }

    return $html;

  }

  private function image($data){

    $html = '<div class="product_img">';

    $html .= '<img src="' . $data['image']['medium'] . '" alt="' . $data['title'] . '">';

    $html .= '</div>';

    return $html;

  }

  private function title($data){

    $html = '<div class="product_title"';

    $html .= ' title="' . $data['title'] . '">';

    $html .= $data['title'];

    $html .= '</div>';

    return $html;

  }

  private function formatPrice($number){

    $config = $this -> config;

    $number = number_format($number, 2, $config['numbers']['decimalSeperator'], $config['numbers']['thousandsSeperator']);

    if($config['numbers']['currencyPosition'] == 'before'){

      $price = $config['numbers']['currencySymbol'] . ' ' . $number;

    }

    if($config['numbers']['currencyPosition'] == 'after'){

      $price = $number . ' ' . $config['numbers']['currencySymbol'];

    }

    return $price;

  }

  private function price($data){

    $html = '<div class="product_price">';

    if($data['price']){

      $html .= '<span>' . $this -> formatPrice($data['price']);

      if(isset($data['oldPrice']) && $data['oldPrice']){

        $html .= '<del>' . $this -> formatPrice($data['oldPrice'] + $data['price']) . '</del>';

      }

      $html .= '</span>';

      // if(isset($data['shop']) && $data['shop']){

        $html .= '<img src="/theme/assets/images/shops/amazon.webp" alt="amazon" class="shopImage">';

      // }

    }

    $html .= '</div>';

    return $html;

  }

  private function clickout($data){

    $html = '<div class="button_offer">';

    $html .= '<span class="link product_btn" data-target="#">Preis prüfen</span>';

    $html .= '</div>';

    return $html;

  }

  public function print($pos, $data, $quick = 0){

    $html = '<div class="card link" ';
    $html .= $this -> dataElements($pos, $data);
    $html .= '>';
    // $html .= $quick == 0 ? $this -> debug($pos, $data) : '';
    $html .= $this -> badge($pos, $data, $quick);
    $html .= $this -> image($data);
    $html .= $this -> title($data);
    $html .= $this -> price($data);
    $html .= $this -> clickout($data);
    $html .= '</div>';

    return $html;

  }
}

?>
