<?php

class buildPage{

  function __construct(){

    $helper = new helper();

    $this -> helper = $helper;

    $config = parse_ini_file('theme/config/conf.ini', true);

    $this -> config = $config;

  }

  private function buildBreadcrumb($data){

    $arrow = '<svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="chevron-right" class="svg-inline--fa fa-chevron-right fa-w-8" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path fill="currentColor" d="M17.525 36.465l-7.071 7.07c-4.686 4.686-4.686 12.284 0 16.971L205.947 256 10.454 451.494c-4.686 4.686-4.686 12.284 0 16.971l7.071 7.07c4.686 4.686 12.284 4.686 16.97 0l211.051-211.05c4.686-4.686 4.686-12.284 0-16.971L34.495 36.465c-4.686-4.687-12.284-4.687-16.97 0z"></path></svg>';

    $home = '<svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="home-lg" class="svg-inline--fa fa-home-lg fa-w-18" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M573.48 219.91L512 170.42V72a8 8 0 0 0-8-8h-16a8 8 0 0 0-8 8v72.6L310.6 8a35.85 35.85 0 0 0-45.19 0L2.53 219.91a6.71 6.71 0 0 0-1 9.5l14.2 17.5a6.82 6.82 0 0 0 9.6 1L64 216.72V496a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V216.82l38.8 31.29a6.83 6.83 0 0 0 9.6-1l14.19-17.5a7.14 7.14 0 0 0-1.11-9.7zM336 480h-96V320h96zm144 0H368V304a16 16 0 0 0-16-16H224a16 16 0 0 0-16 16v176H96V190.92l187.71-151.4a6.63 6.63 0 0 1 8.4 0L480 191z"></path></svg>';

    $html = '<div class="post-header">
      <div class="container">
        <p class="breadcrumbs">
          <a href="https://www.netzvergleiche.de">' . $home . '</a>';

    foreach(array_unique(explode(' > ', $data['breadcrumb'])) as $breadcrumb){

      $html .= $arrow . '<a href="/' . $this -> helper -> slugify($breadcrumb) . '/">' . $breadcrumb . '</a>';

    }

    $html .= '</p>';

    return $html;

  }

  private function buildHeader($data){

    $html = '<div class="header-content"><div class="post-header-title">';

    $html .= '<h1>' . ucwords($data['name'], " \t\r\n\f\v'") . ' im Vergleich</h1>';
    $html .= '<h2>Die ' . count($data['products']['active']) . ' besten Produkte für die Suche: ' .
      ucwords($data['name']) . '</h2>';

    $html .= '</div>';

    $html .='</div></div>';

    return $html;

  }

  private function buildSidebar($data){

    $html = '<div class="sidebar">';

    if($data['brands']){

      $html .= '<h5>Marken</h5><div class="filterSelection">';

      foreach($data['brands'] as $brand){
        if($brand != '' && mb_strtolower($brand) != ($this -> config)['words']['unknownBrand']){

          $html .= '<div class="filterLine">
            <input type="checkbox" name="filter" id="' . $brand . '" value="' . $brand . '">
            <label for="' . $brand . '">' . $brand . '</label>
          </div>';

        }
      }

      $html .= '</div>';

    }

    $html .= '</div>';

    return $html;

  }

  private function buildCategoryBody($data){

    $html = '<div class="post-table">
      <div class="container">';

    $html .= $this -> buildSidebar($data['data']);

    $html .= '<div class="card-grid">
                <div class="card-grid-header">
                  <div class="sort">
                    <label for="sort">Sortieren nach:</label>
                    <select class="btn btn-img" name="sort">
                      <option value="relevance">Relevanz</option>
                      <option value="price">Preis aufsteigend</option>
                      <option value="discount">Rabatt</option>
                    </select>
                  </div>
                  <div class="filter">
                    <a class="btn btn-img" href="#">Filter</a>
                  </div>
                </div>';

    if(count($data['data']['products']['active']) > 0){

      $card = new productCard();

      foreach($data['data']['products']['active'] as $pos => $row){

        $html .= $card -> print($pos, $row);

      }
    }

    $html .= '</div></div></div>';

    return $html;

  }

  private function buildCategoryFooter($inactiveProducts){

    $html = '';

    if(count($inactiveProducts) > 0){

      $html .= '<div class="footer-carousel">
            <div class="container">

              <h3>
                Oft zusammen angesehen
                <small>Andere Kunden interessierten sich auch für diese Produkte</small>
              </h3>

              <ul id="lightSlider">';

        foreach($inactiveProducts as $pos => $row){

          $card = new productCard();
          $html .= '<li>' . $card -> print($pos, $row) . '</li>';

        }

      $html .= '</ul>
          <div class="lSAction"><a id="goToPrevSlide" class="lSPrev"></a><a id="goToNextSlide" class="lSNext"></a></div>
        </div>
      </div>';
    }

    return $html;

  }

  public function print($data){

    $html = $this -> buildBreadcrumb($data['data']);
    $html .= $this -> buildHeader($data['data']);
    $html .= $this -> buildCategoryBody($data);

    if(isset($data['data']['products']['inactive'])){
      $html .= $this -> buildCategoryFooter($data['data']['products']['inactive']);
    }

    return $html;

  }

}

?>
