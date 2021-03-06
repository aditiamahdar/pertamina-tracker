<?php
include "config.php";
include "spbu_module.php";
$mysqli->close();
?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

  <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">

  <link rel="stylesheet" type="text/css" href="css/jquery-ui-1.10.0.custom.min.css"/>
  <link rel="stylesheet" type="text/css" href="css/jquery-ui-timepicker-addon.css"/>
  <link rel="stylesheet" type="text/css" href="css/leaflet.css"/>
  <link rel="stylesheet" type="text/css" href="css/style.css"/>
  <script type="text/javascript">
    var spbu_data = <?php echo json_encode($spbu_rows);?>;
  </script>
  <script src='js/leaflet.js'></script>

  <!--[if lte IE 9]><script language="javascript" type="text/javascript" src="js/excanvas.min.js"></script><![endif]-->

  <script src="js/jquery.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/jquery.ui.touch-punch.min.js"></script>
  <script src="js/timepicker.js"></script>
  <script src="js/jquery.localisation.js"></script>

  <script src="js/jquery.flot.js"></script>
  <script src="js/jquery.flot.navigate.js"></script>
  <script src="js/jquery.flot.fillarea.js"></script>
  <script src="js/jquery.flot.time.js"></script>
  <script src="js/jquery.flot.resize.js"></script>

  <script src="//apps.wialon.com/plugins/leaflet/webgis/webgis.leaflet.js"></script>
  <script src="js/messages.js"></script>
  <script src="js/sensors.js"></script>
  <script src="js/script1.js"></script>
  <script>
    var availableLanguages=null;
    var documentationLink=null;
    var is_white=null;
    var APP_CONFIG = {};
    function appPredefineVariables(app_langs,doc_link,is_whitelabeled,config){
      availableLanguages=app_langs;
      documentationLink=is_whitelabeled?(config.help_url_link ? decodeURIComponent(config.help_url_link) : null):doc_link;
      is_white=is_whitelabeled;
      APP_CONFIG=config;
    }
  </script>
  <style type="text/css">
    .marker-pin {
      width: 30px;
      height: 30px;
      border-radius: 50% 50% 50% 0;
      background: #c30b82;
      position: absolute;
      transform: rotate(-45deg);
      left: 50%;
      top: 50%;
      margin: -15px 0 0 -15px;
    }
    .marker-pin::after {
        content: '';
        width: 20px;
        height: 20px;
        margin: 5px 0 0 5px;
        background: #fff;
        position: absolute;
        border-radius: 50%;
     }
    .spbu-number {
      position: absolute;
      left: 32px;
      top: 10px;
      background: #ed1b30;
      padding: 1.5px 5px;
      border-radius: 3px;
      color: white;
      font-size: 11px;
    }
  </style>
</head>
<body>
  <div id="header">
    <img class="logo" src="img/logo_Fleetsight.png"/><span class="app_name"></span><div id="help"></div>
  </div>
  <div id="layout">
    <div id="menu">
      <div class="header">
        <div class="row"><div id="tr_interval" class="label"></div><select id="time_interval"></select></div>
        <div class="row" id="timepickers"><div class="label"></div><input class="datetime" id="t_begin"/><span style="margin:0 8px;">-</span><input class="datetime" id="t_end"/></div>
        <div class="row">
          <div class="label" id="tr_unit"></div><select id="units"></select>
          <div id="color"><div class="template active" style="background:#679A01" data-marker="green" data-bckgrnd="679a01"><div style="display:block;"></div></div><div class="template" style="background:#009a2f" data-marker="dark-green" data-bckgrnd="009a2f"><div></div></div><div class="template" style="background:#009999" data-marker="turquoise" data-bckgrnd="009999"><div></div></div><div class="template" style="background:#0069ce" data-marker="blue" data-bckgrnd="0069ce"><div></div></div><div class="template" style="background:#3233ff" data-marker="violet" data-bckgrnd="3233ff"><div></div></div><div class="template" style="background:#6734cd" data-marker="stronge-violet" data-bckgrnd="6734cd"><div></div></div><div class="template" style="background:#9b31d1" data-marker="fuchsia" data-bckgrnd="9b31d1"><div></div></div><div class="template" style="background:#ff005a" data-marker="pink" data-bckgrnd="ff005a"><div></div></div><div class="template" style="background:#fe0000" data-marker="red" data-bckgrnd="fe0000"><div></div></div><div class="template" style="background:#fa9b03" data-marker="orange" data-bckgrnd="fa9b03"><div></div></div></div>
        </div>
        <div class="buttons row">
          <!-- <div class="btn_wrapper" style="margin-right:5px;"><input class="menu_btn" disabled id="set_interval_btn" type="button" value=""/></div> -->
          <div class="btn_wrapper" style="margin-right:30px;"><input class="menu_btn" disabled id="add_btn" type="button" value=""/></div>
        </div>
      </div>
      <div class="tracks"><div id="tr_tracks"></div></div>
      <div id="tracks_list"></div>
    </div>
    <div id="map"></div>
    <div id="control-wrapper">
      <div id="control">
        <div id="info_block">
          <div id="photos"></div>
          <div id="graph"></div>
        </div>
        <div id="playline_block">
          <div class="b1">
            <div id="step_val" title="">10x</div>
            <button disabled id="play_btn" type="button"></button>
            <div id="t_curr"><span class="d"></span><span class="t"></span></div>
            <button disabled id="tostart_btn" type="button"></button>
            <button disabled id="stepleft_btn" type="button"></button>
          </div>
          <div class="timeline_wrapper">
            <div id="range"></div>
            <div id="slider"></div>
          </div>
          <div class="b2">
            <button disabled id="stepright_btn" type="button" ></button>
            <button disabled id="toend_btn" type="button" ></button>
            <button disabled id="settings_btn" type="button" ></button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Dialogs and popups -->
  <img id="photo_hover" src="img/logo.png"/>
  <div id="dialog">
    <div class="header">
      <span id="tr_monitoring_info"></span><a id="tr_hide_dialog" title="" href="#" onclick="$('#dialog').hide();return false;">&#x2715;</a>
    </div>
    <div class="row" style="cursor: auto;">
      <input id="rotate_icon" type="checkbox"/><label id="tr_rotate_icon" style="color:#fff;" for="rotate_icon"></label>
    </div>
    <div id="selected_options" class="all_params"></div>
    <div class="plain_text"></div>
    <div>
      <div class="label" tabindex="-1"><span id="tr_common"></span><img src="img/show.png"/></div>
      <div id="commons" class="all_params"></div>
    </div>
    <div>
      <div class="label" tabindex="-1"><span id='tr_sensors'></span><img src="img/show.png"/></div>
      <div id="sensors" class="all_params"></div>
    </div>
  </div>
  <div id="step_wrapper" tabindex="-1" class="dialog">
    <div id="step" tabindex="-1"></div>
  </div>
  <div id="settings_dialog" class="dialog">
    <div class="row">
      <input id="skip_trips_ch" type="checkbox"/><label id="tr_skip_trips" for="skip_trips_ch"></label>
    </div>
  </div>
</body>
</html>
