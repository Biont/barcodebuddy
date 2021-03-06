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
 * @since      File available since Release 1.2
 */


/**
 * Change quantities
 *
 * @author     Marc Ole Bulling
 * @copyright  2019 Marc Ole Bulling
 * @license    https://www.gnu.org/licenses/gpl-3.0.en.html  GNU GPL v3.0
 * @since      File available since Release 1.2
 *
 */



require_once __DIR__ . "/../incl/config.php";
require_once __DIR__ . "/../incl/api.inc.php";
require_once __DIR__ . "/../incl/db.inc.php";
require_once __DIR__ . "/../incl/processing.inc.php";
require_once __DIR__ . "/../incl/websocketconnection.inc.php";
require_once __DIR__ . "/../incl/webui.inc.php";



//Delete Quantitiy 
if (isset($_POST["button_delete"])) {
        $id = $_POST["button_delete"];
        checkIfNumeric($id);
        $db->deleteQuantitiy($id);
        //Hide POST, so we can refresh
        header("Location: " . $_SERVER["PHP_SELF"]);
        die();
    }



$webUi = new WebUiGenerator(MENU_GENERIC);
$webUi->addHeader();
$webUi->addCard("Saved Quantities",printSettingsQuantityTable());
$webUi->addFooter();
$webUi->printHtml();





function printSettingsQuantityTable(){
    global $db;
    $quantities = $db->getQuantities();
    $html = new UiEditor();
    if (sizeof($quantities) == 0) {
        $html->addHtml("No saved quantities yet.");
        return $html->getHtml();
    } else {
        $returnString = '<form name="form" method="post" action="' . $_SERVER['PHP_SELF'] . '" >';
        $table        = new TableGenerator(array(
            "Product",
            "Barcode",
            "Quantitiy",
            "Action"
        ));
        
        foreach ($quantities as $quantity) {
            $table->startRow();
            $table->addCell($quantity['product']);
            $table->addCell($quantity['barcode']);
            $table->addCell($quantity['quantitiy']);
            $table->addCell($html->buildButton("button_delete", "Delete")
                                ->setSubmit()
                                ->setValue($quantity['id'])
                                ->generate(true));
            $table->endRow();
        }
        $html->addTableClass($table);
        return $html->getHtml();
    }

}
?>
