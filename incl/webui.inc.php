<?php
/**
 * Barcode Buddy for Grocy
 *
 * PHP version 7
 *
 * LICENSE: This source file is subject to version 3.0 of the GNU General
 * Public License v3.0 that is attached to this project.
 *
 * @author     Marc Ole Bulling
 * @copyright  2019 Marc Ole Bulling
 * @license    https://www.gnu.org/licenses/gpl-3.0.en.html  GNU GPL v3.0
 * @since      File available since Release 1.0
 */


/**
 * functions for web ui
 * 
 * @author     Marc Ole Bulling
 * @copyright  2019 Marc Ole Bulling
 * @license    https://www.gnu.org/licenses/gpl-3.0.en.html  GNU GPL v3.0
 * @since      File available since Release 1.0
 *
 */


require_once __DIR__ . "/config.php";
require_once __DIR__ . "/uiEditor.inc.php";

const MENU_GENERIC = 0;
const MENU_MAIN = 1;
const MENU_SETUP = 2;
const MENU_SETTINGS = 3;
const MENU_ERROR = 4;



class WebUiGenerator {
    private $htmlOutput = "";
    private $menu = MENU_GENERIC;
    
    function __construct($menu) {
        $this->menu = $menu;
    }


    function addHtml($html) {
        $this->htmlOutput = $this->htmlOutput .$html;
    }


    function printHtml() {
        echo $this->htmlOutput;
    }
    

    function addCard($title, $html, $linkText=null, $onClick=null) {
        $this->htmlOutput = $this->htmlOutput.'
        <section class="section--center mdl-grid--no-spacing mdl-grid mdl-shadow--2dp">
            <div class="mdl-card mdl-cell  mdl-cell--12-col">
              <div class="mdl-card__supporting-text" style="overflow-x: auto; ">
                <h4>'.$title.'</h4><br>
        '.$html.'
        </div>
            </div>';
     if ($linkText !=null &&  $onClick!=null) {
        $id=rand();
       $this->htmlOutput = $this->htmlOutput.'<button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="btn'.$id.'">
              <i class="material-icons">more_vert</i>
            </button>
            <ul class="mdl-menu mdl-js-menu mdl-menu--bottom-right" for="btn'.$id.'">
              <li class="mdl-menu__item" onclick="'.$onClick.'">'.$linkText.'</li>
            </ul>';
    }
          $this->htmlOutput = $this->htmlOutput.'</section>';
    }

    function addHeader() {
        require_once __DIR__ . "/db.inc.php";
        global $BBCONFIG;
        
        if ($this->menu == MENU_SETTINGS || $this->menu == MENU_GENERIC) {
            $folder = "../";
        } else {
            $folder = "./";
        }
        if ($this->menu == MENU_SETUP || $this->menu == MENU_ERROR) {
            $indexfile = "setup.php";
        } else {
            $indexfile = "index.php";
        }
        $this->htmlOutput = $this->htmlOutput . '<!doctype html>
    <html lang="en">
      <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
        <title>Barcode Buddy</title>

        <!-- Add to homescreen for Chrome on Android -->
    <!--    <meta name="mobile-web-app-capable" content="yes">
        <link rel="icon" sizes="192x192" href="images/android-desktop.png"> -->

        <!-- Add to homescreen for Safari on iOS -->
    <!--    <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="apple-mobile-web-app-title" content="Material Design Lite">
        <link rel="apple-touch-icon-precomposed" href="images/ios-desktop.png">

        <link rel="shortcut icon" href="images/favicon.png"> -->

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-blue.min.css">
        <link rel="stylesheet" href="' . $folder . 'styles.css">

      </head>

     <body class="mdl-demo mdl-color--grey-100 mdl-color-text--grey-700 mdl-base">

    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
      <header class="mdl-layout__header">
        <div class="mdl-layout__header-row">
          <!-- Title -->
          <span class="mdl-layout-title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a style="color: white; text-decoration: none;" href="' . $folder . $indexfile . '">Barcode Buddy</a></span>
          <!-- Add spacer, to align navigation to the right -->
          <div class="mdl-layout-spacer"></div>';
        if ($this->menu != MENU_SETUP && $this->menu != MENU_ERROR) {
            $this->htmlOutput = $this->htmlOutput . '      <nav class="mdl-navigation mdl-layout--always"><a class="mdl-navigation__link" target="_blank" href="' . str_replace("api/", "", $BBCONFIG["GROCY_API_URL"]) . '">Grocy</a>';
                $this->htmlOutput = $this->htmlOutput . '<a class="mdl-navigation__link" target="_blank" href="' . $folder . 'screen.php">Screen</a>';
            $this->htmlOutput = $this->htmlOutput . '</nav>';
        }
        $this->htmlOutput = $this->htmlOutput . '  </div>
      </header>';
        if ($this->menu != MENU_SETUP && $this->menu != MENU_ERROR) {
            $this->htmlOutput = $this->htmlOutput . '<div class="mdl-layout__drawer">
        <span class="mdl-layout-title">Menu</span>
        <nav class="mdl-navigation">
          <a class="mdl-navigation__link" href="' . $folder . 'index.php">Overview</a>
          <a class="mdl-navigation__link" href="' . $folder . 'menu/settings.php">Settings</a>
          <a class="mdl-navigation__link" href="' . $folder . 'menu/quantities.php">Quantities</a>
          <a class="mdl-navigation__link" href="' . $folder . 'menu/chores.php">Chores</a>
          <a class="mdl-navigation__link" href="' . $folder . 'menu/tags.php">Tags</a>
        </nav>
      </div>';
        }
    $this->htmlOutput = $this->htmlOutput . '<main class="mdl-layout__content" style="flex: 1 0 auto;">
      <div class="mdl-layout__tab-panel is-active" id="overview">';
    }

    function addFooter() {
        $this->htmlOutput = $this->htmlOutput . ' <section class="section--footer mdl-grid">
          </section>
<div aria-live="assertive" aria-atomic="true" aria-relevant="text" class="mdl-snackbar mdl-js-snackbar">
    <div class="mdl-snackbar__text"></div>
    <button type="button" class="mdl-snackbar__action"></button>
</div>


<footer class="mdl-mini-footer">
      <div class="mdl-mini-footer__left-section">
        <div class="mdl-logo">Barcode Buddy </div>
        <ul class="mdl-mini-footer__link-list">
              <li><a href="https://barcodebuddy-documentation.readthedocs.io/en/latest/">Documentation</a></li>
              <li><a href="https://github.com/Forceu/barcodebuddy/">Source Code</a></li>
              <li><a href="https://github.com/Forceu/barcodebuddy/blob/master/LICENSE">License</a></li>
          <li>Version ' . BB_VERSION_READABLE . '</li>
              <li>by Marc Ole Bulling</li>
        </ul>
      </div>
    </footer>
          </div></main>';

        if ($this->menu == MENU_MAIN) {
            $this->htmlOutput = $this->htmlOutput . '<div id="myModal" class="modal">

          <!-- Modal content -->
          <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Add barcode</h2>

        Enter your barcodes below, one each line.&nbsp;<br><br>
        <form name="form" onsubmit="disableSSE()" method="post" action="' . $_SERVER['PHP_SELF'] . '" >
        <textarea name="newbarcodes" id="newbarcodes" class="mdl-textfield__input" rows="15"></textarea>
        <span style="font-size: 9px;">It is recommended to use a script that grabs the barcode scanner input, instead of doing it manually. See the <a href="https://github.com/Forceu/barcodebuddy" rel="noopener noreferrer" target="_blank">project website</a> on how to do this.</span><br><br><br>


        <button  class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--accent mdl-color-text--accent-contrast" name="button_add_manual" type="submit" value="Add">Add</button>​
        </form>
          </div>
        </div>
         <button id="add-barcode" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--accent mdl-color-text--accent-contrast">Add barcode</button> ';
        }
        if ($this->menu == MENU_SETTINGS) {
            $this->htmlOutput = $this->htmlOutput . '<button id="save-settings" onclick="checkAndReturn()" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--accent mdl-color-text--accent-contrast">Save</button>';
        }
        $this->htmlOutput = $this->htmlOutput . '</div><script src="https://code.getmdl.io/1.3.0/material.min.js"></script>';

        if ($this->menu == MENU_SETTINGS || $this->menu == MENU_GENERIC) {
            $this->htmlOutput = $this->htmlOutput . '<script src="../incl/scripts.js"></script>';
        } else {
            $this->htmlOutput = $this->htmlOutput . '<script src="./incl/scripts.js"></script>';
        }

        if ($this->menu == MENU_MAIN) {
            $this->htmlOutput = $this->htmlOutput . '<script> 

        var eventSource = null;

        function disableSSE() {
            if (eventSource!=null)
                eventSource.close();
        }

        var modal = document.getElementById("myModal");
        var btn = document.getElementById("add-barcode");
        var span = document.getElementsByClassName("close")[0];
        btn.onclick = function() {
          modal.style.display = "block";
          btn.style.display = "none";
        document.getElementById("newbarcodes").focus();
        }
        span.onclick = function() {
          modal.style.display = "none";
          btn.style.display = "block";
        }
        window.onclick = function(event) {
          if (event.target == modal) {
            modal.style.display = "none";
            btn.style.display = "block";
          }
        }

        const delay = ms => new Promise(res => setTimeout(res, ms));

        const startWebsocket = async () => {
            /* waiting 1s in case barcode was added from ui */
        await delay(1000);

        eventSource = new EventSource("incl/sse/sse_data.php");
        eventSource.onmessage = function(event) {
            var resultJson = JSON.parse(event.data);
                var resultCode = resultJson.data.substring(0, 1);
                var resultText = resultJson.data.substring(1);  
                switch(resultCode) {
                    case \'0\':
                    case \'1\':
                    case \'2\':

                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                      if (this.readyState == 4 && this.status == 200) {
                          var content = JSON.parse(this.responseText);
                          var card1 = document.getElementById("f1");
                          card1.innerHTML = content.f1;
                          var card2 = document.getElementById("f2");
                          card2.innerHTML = content.f2;
                          var card3 = document.getElementById("f3");
                          card3.innerHTML = content.f3;
                      }
                    };
                    xhttp.open("GET", "index.php?ajaxrefresh", true);
                    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhttp.send();
                        break;
                      }
                  };
                };
                if(typeof(EventSource) !== "undefined")
                  startWebsocket();

        </script>';
        }
        $this->htmlOutput = $this->htmlOutput . '</body>
    </html>';
    }

}

class TableGenerator {
    private $htmlOutput = "";
    
    function __construct($tableHeadItems) {
        $this->htmlOutput  = '<table class="mdl-data-table mdl-js-data-table mdl-cell">
                 <thead>
                    <tr>';
        foreach ($tableHeadItems as $item) {
                $this->htmlOutput = $this->htmlOutput . '<th class="mdl-data-table__cell--non-numeric">' . $item . '</th>';
        }
        $this->htmlOutput = $this->htmlOutput . '    </tr>
                  </thead>
                  <tbody>';
    }
    
    
    function startRow() {
        $this->htmlOutput = $this->htmlOutput . '<tr>';
    }

    function addCell($html) {
            $this->htmlOutput = $this->htmlOutput . '<td class="mdl-data-table__cell--non-numeric">' . $html . '</td>';
    }

    function endRow() {
        $this->htmlOutput = $this->htmlOutput . '</tr>';
    }
    
    function getHtml() {
        return $this->htmlOutput . '</tbody></table>';
    }
    
}


function hideGetPostParameters() {
  header("Location: " . $_SERVER["PHP_SELF"]);
  die();
}


?>
