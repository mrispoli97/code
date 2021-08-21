<?php if(isset($filter['data'])){ ?>
  <div class="tooltip" style="position: fixed; bottom: 20px; top: unset; right: 50%">i
    <span class="tooltiptext" style="width: 450px; left: calc(50% - 100px);">
      <?php foreach($data['data']['filter'] as $filter){ ?>
        <?php if(isset($filter['attribute'])){ ?>
        <h4><?php echo $filter['attribute'] ?></h4>
        <p>
          Min: <?php echo $filter['Q1'] ?></br>
          Max: <?php echo $filter['Q3'] ?>
        </p>
      <?php } } ?>
    </span>
  </div>
<?php } ?>
<footer>
  <div class="footer-top">
  <div class="container">
  <div class="logo">
  <a href="https://www.netzvergleiche.de/" class="custom-logo-link" rel="home"><img width="335" height="57" src="https://www.netzvergleiche.de/wp-content/uploads/netzvergleich_57px.png" class="custom-logo" alt="Netzvergleich" srcset="https://www.netzvergleiche.de/wp-content/uploads/netzvergleich_57px.png 335w, https://www.netzvergleiche.de/wp-content/uploads/netzvergleich_57px-300x51.png 300w" sizes="(max-width: 335px) 100vw, 335px" /></a></div>
   <p><b>Unternehmen</b></p>
  <div class="menu-footer-menu-container"><ul id="menu-footer-menu" class="menu"><li id="menu-item-292155" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-292155"><a href="https://www.netzvergleiche.de/legal/impressum/">Impressum</a></li>
  <li id="menu-item-292153" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-292153"><a href="https://www.netzvergleiche.de/legal/bildnachweise/">Bildnachweise</a></li>
  <li id="menu-item-292154" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-292154"><a href="https://www.netzvergleiche.de/legal/datenschutz/">Datenschutzerklärung</a></li>
  </ul></div>
  </div>
  </div>
  <div class="footer-bottom">
  <div class="container">
  <div class="grid-xl-9 grid-xl-9 grid-md-12 grid-sm-12 left">
  <span class="footer-bottom-legal-note"></span>
  </div>
  <div class="grid-xl-3 grid-xl-3 grid-md-12 grid-sm-12 right">
  © 2021 Founderslink GmbH
  </div>
  </div>
  </div>
  <svg width="100" height="50" version="1.1" xmlns="http://www.w3.org/2000/svg">
  <style type="text/css">
  		rect{fill:url(#StarGradient)}
  	</style>
  <defs>
  <linearGradient id="StarGradient" gradientTransform="rotate(90)">
  <stop offset="5%" stop-color="#f9de15" />
  <stop offset="95%" stop-color="#f9a515" />
  </linearGradient>
  </defs>
  <rect width="100" height="50" />
  </svg>
</footer>
<div class="cookie-banner">
  <div class="cookie-container">
  <span class="closebtn">OK</span>
  <p>
  <strong>Wichtig!</strong> Netzvergleiche.de verdient ggf. Geld, wenn Sie auf Links klicken. Unsere Wertungen bleiben davon unbeeinflusst. <a href="/ueber-uns/">Weitere Informationen.</a> Netzvergleiche.de benutzt Cookies zur Analyse des Nutzerverhaltens.
  </p>
  </div>
</div>
<script type='text/javascript'>
  /* <![CDATA[ */
  var tocplus = {"smooth_scroll":"1","smooth_scroll_offset":"150"};
  /* ]]> */
</script>
<script type='text/javascript' src='https://www.netzvergleiche.de/wp-content/themes/Netzvergleiche-Theme-master/assets/build/script.min.js?ver=1615911733'></script>
<script type="text/javascript"><?php echo file_get_contents('/var/www/html/theme/assets/scripts.min.js'); ?></script>
<!-- <script type='text/javascript' src='https://emmi-findet.de/cf18bf6f64e3fa2b332ff6c1466a5e8e.min.js?ver=5.2.9'></script> -->
</body>
</html>
