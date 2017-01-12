<?php
/**
 * PHP Grid Component
 *
 * @author Abu Ghufran <gridphp@gmail.com> - http://www.phpgrid.org
 * @version 1.5.2 build 20140512-0107
 * @license: see license.txt included in package
 */
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
ini_set("display_errors", "off");

class jqgrid {

    var $Vb80bb7740288fda1f201890375a60c;
    var $options = array();
    var $V86c223b5ea2c7e35154ae4410cd891 = array();
    var $Vd1efad72dc5b17dc66a46767c32fff = array();
    var $select_command;
    var $table;
    var $actions;
    var $debug;
    var $V7ed201fa20d25d22b291dc85ae9e5c;
    var $V82e89bfbf8b0b8c2424e5e654b00b8;
    var $events;

    function jqgrid($V874bee6889064844cae94871a8342a = null) {
        if (PHPGRID_AUTOCONNECT == 1) {
            $V874bee6889064844cae94871a8342a = array();
            $V874bee6889064844cae94871a8342a["type"] = PHPGRID_DBTYPE;
            $V874bee6889064844cae94871a8342a["server"] = PHPGRID_DBHOST;
            $V874bee6889064844cae94871a8342a["user"] = PHPGRID_DBUSER;
            $V874bee6889064844cae94871a8342a["password"] = PHPGRID_DBPASS;
            $V874bee6889064844cae94871a8342a["database"] = PHPGRID_DBNAME;
        } session_start();
        $this->V82e89bfbf8b0b8c2424e5e654b00b8 = "mysql";
        $this->debug = 1;
        $this->error_msg = "Some issues occured in this operation, Contact technical support for help";
        @mysql_query("SET NAMES 'utf8'");
        if ($V874bee6889064844cae94871a8342a) {
            include_once("adodb/adodb.inc.php");
            $Ve2d45d57c7e2941b65c6ccd64af422 = $V874bee6889064844cae94871a8342a["type"];
            $this->V7ed201fa20d25d22b291dc85ae9e5c = ADONewConnection($Ve2d45d57c7e2941b65c6ccd64af422);
            $this->V7ed201fa20d25d22b291dc85ae9e5c->SetFetchMode(ADODB_FETCH_ASSOC);
            $this->V7ed201fa20d25d22b291dc85ae9e5c->debug = 0;
            $this->V7ed201fa20d25d22b291dc85ae9e5c->Connect($V874bee6889064844cae94871a8342a["server"], $V874bee6889064844cae94871a8342a["user"], $V874bee6889064844cae94871a8342a["password"], $V874bee6889064844cae94871a8342a["database"]);
            if ($V874bee6889064844cae94871a8342a["type"] == "mysql" || $V874bee6889064844cae94871a8342a["type"] == "mysqli")
                $this->V7ed201fa20d25d22b291dc85ae9e5c->Execute("SET NAMES 'utf8'");
            $this->V82e89bfbf8b0b8c2424e5e654b00b8 = $V874bee6889064844cae94871a8342a["type"];
        } $Vff4a008470319a22d9cf3d14af4859["datatype"] = "json";
        $Vff4a008470319a22d9cf3d14af4859["rowNum"] = 20;
        $Vff4a008470319a22d9cf3d14af4859["width"] = 900;
        $Vff4a008470319a22d9cf3d14af4859["height"] = 350;
        $Vff4a008470319a22d9cf3d14af4859["rowList"] = array(10, 20, 30, 'All');
        $Vff4a008470319a22d9cf3d14af4859["viewrecords"] = true;
        $Vff4a008470319a22d9cf3d14af4859["multiSort"] = false;
        $Vff4a008470319a22d9cf3d14af4859["scrollrows"] = true;
        $Vff4a008470319a22d9cf3d14af4859["toppager"] = false;
        $Vff4a008470319a22d9cf3d14af4859["prmNames"] = array("page" => "jqgrid_page");
        $Vff4a008470319a22d9cf3d14af4859["sortname"] = "1";
        $Vff4a008470319a22d9cf3d14af4859["sortorder"] = "asc";
        $Vff4a008470319a22d9cf3d14af4859["form"]["nav"] = false;
        $Vff4a008470319a22d9cf3d14af4859["url"] = "http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $Vff4a008470319a22d9cf3d14af4859["editurl"] = $Vff4a008470319a22d9cf3d14af4859["url"];
        $Vff4a008470319a22d9cf3d14af4859["cellurl"] = $Vff4a008470319a22d9cf3d14af4859["url"];
        $Vff4a008470319a22d9cf3d14af4859["scroll"] = 0;
        $Vff4a008470319a22d9cf3d14af4859["sortable"] = true;
        $Vff4a008470319a22d9cf3d14af4859["cellEdit"] = false;
        $Vff4a008470319a22d9cf3d14af4859["add_options"] = array("recreateForm" => true, "closeAfterAdd" => true, "closeOnEscape" => true, "errorTextFormat" => "function(r){ return r.responseText;}", "jqModal" => true);
        $Vff4a008470319a22d9cf3d14af4859["edit_options"] = array("recreateForm" => true, "closeAfterEdit" => true, "closeOnEscape" => true, "errorTextFormat" => "function(r){ return r.responseText;}", "jqModal" => true);
        $Vff4a008470319a22d9cf3d14af4859["delete_options"] = array("closeOnEscape" => true, "errorTextFormat" => "function(r){ return r.responseText;}");
        $Vff4a008470319a22d9cf3d14af4859["view_options"]["closeOnEscape"] = true;
        $Vff4a008470319a22d9cf3d14af4859["form"]["position"] = "center";
        $this->options = $Vff4a008470319a22d9cf3d14af4859;
        $this->actions["showhidecolumns"] = false;
        $this->actions["inlineadd"] = false;
        $this->actions["search"] = "";
        $this->actions["export"] = false;
    }

    public function strip($V2063c1608d6e0baf80249c42e2be58) { {
            if (is_array($V2063c1608d6e0baf80249c42e2be58))
                if (array_is_associative($V2063c1608d6e0baf80249c42e2be58)) {
                    foreach ($V2063c1608d6e0baf80249c42e2be58 as $V8ce4b16b22b58894aa86c421e8759d => $V9e3669d19b675bd57058fd4664205d)
                        $Vafb0f4ba8bde6746418ba7f1fbfc9e[$V8ce4b16b22b58894aa86c421e8759d] = stripslashes($V9e3669d19b675bd57058fd4664205d);
                    $V2063c1608d6e0baf80249c42e2be58 = $Vafb0f4ba8bde6746418ba7f1fbfc9e;
                } else
                    for ($V363b122c528f54df4a0446b6bab055 = 0; $V363b122c528f54df4a0446b6bab055 < sizeof($V2063c1608d6e0baf80249c42e2be58); $V363b122c528f54df4a0446b6bab055++)
                        $V2063c1608d6e0baf80249c42e2be58[$V363b122c528f54df4a0446b6bab055] = stripslashes($V2063c1608d6e0baf80249c42e2be58[$V363b122c528f54df4a0446b6bab055]); 
            else
                $V2063c1608d6e0baf80249c42e2be58 = stripslashes($V2063c1608d6e0baf80249c42e2be58);
        } return $V2063c1608d6e0baf80249c42e2be58;
    }

    private function construct_where($V03c7c0ace395d80182db07ae2c30f0) {
        $V48c03a144a8065f6d4e23bd63008be = "";
        $Vcca5019fe7f1443635095966d2a91c = array('eq' => " = ", 'ne' => " <> ", 'lt' => " < ", 'le' => " <= ", 'gt' => " > ", 'ge' => " >= ", 'bw' => " LIKE ", 'bn' => " NOT LIKE ", 'in' => " IN ", 'ni' => " NOT IN ", 'ew' => " LIKE ", 'en' => " NOT LIKE ", 'cn' => " LIKE ", 'nu' => " IS NULL ", 'nn' => " IS NOT NULL ", 'nc' => " NOT LIKE ");
        if ($V03c7c0ace395d80182db07ae2c30f0) {
            $Vdecafcb60f8d918adb56fddeeb7152 = (array) json_decode($V03c7c0ace395d80182db07ae2c30f0, true);
            if (is_array($Vdecafcb60f8d918adb56fddeeb7152)) {
                $Ved780ed8cfdb7ec7cb361f834350ac = $Vdecafcb60f8d918adb56fddeeb7152['groupOp'];
                $Va4f86f7bfc24194b276c22e0ef1581 = $Vdecafcb60f8d918adb56fddeeb7152['rules'];
                $V865c0c0b4ab0e063e5caa3387c1a87 = 0;
                foreach ($Va4f86f7bfc24194b276c22e0ef1581 as $V3c6e0b8a9c15224a8228b9a98ca153 => $V3a6d0284e743dc4a9b86f97d6dd1a3) {
                    $V3a6d0284e743dc4a9b86f97d6dd1a3 = (array) $V3a6d0284e743dc4a9b86f97d6dd1a3;
                    $V11d8c28a64490a987612f233250246 = $V3a6d0284e743dc4a9b86f97d6dd1a3['op'];
                    foreach ($this->options["colModel"] as $V73d4fc339cd9a5a0e79143fd3fc999) {
                        if ($V3a6d0284e743dc4a9b86f97d6dd1a3['field'] == $V73d4fc339cd9a5a0e79143fd3fc999["name"] && !empty($V73d4fc339cd9a5a0e79143fd3fc999["formatoptions"]) && in_array($V11d8c28a64490a987612f233250246, array("cn", "ne", "eq", "gt", "ge", "lt", "le"))) {
                            if ($V73d4fc339cd9a5a0e79143fd3fc999["formatoptions"]["newformat"] == "d/m/Y") {
                                $Vfa816edb83e95bf0c8da580bdfd491 = explode("/", $V3a6d0284e743dc4a9b86f97d6dd1a3['data']);
                                $V3a6d0284e743dc4a9b86f97d6dd1a3['data'] = $Vfa816edb83e95bf0c8da580bdfd491[1] . "/" . $Vfa816edb83e95bf0c8da580bdfd491[0] . "/" . $Vfa816edb83e95bf0c8da580bdfd491[2];
                            } if ($V73d4fc339cd9a5a0e79143fd3fc999["formatter"] == "date")
                                $V3a6d0284e743dc4a9b86f97d6dd1a3['data'] = date("Y-m-d", strtotime($V3a6d0284e743dc4a9b86f97d6dd1a3['data']));
                            else if ($V73d4fc339cd9a5a0e79143fd3fc999["formatter"] == "datetime")
                                $V3a6d0284e743dc4a9b86f97d6dd1a3['data'] = date("Y-m-d H:i:s", strtotime($V3a6d0284e743dc4a9b86f97d6dd1a3['data']));
                        } if ($V3a6d0284e743dc4a9b86f97d6dd1a3['field'] == $V73d4fc339cd9a5a0e79143fd3fc999["name"] && !empty($V73d4fc339cd9a5a0e79143fd3fc999["dbname"])) {
                            $V3a6d0284e743dc4a9b86f97d6dd1a3['field'] = $V73d4fc339cd9a5a0e79143fd3fc999["dbname"];
                        }
                    } $V06e3d36fa30cea095545139854ad1f = $V3a6d0284e743dc4a9b86f97d6dd1a3['field'];
                    $V9e3669d19b675bd57058fd4664205d = $V3a6d0284e743dc4a9b86f97d6dd1a3['data'];
                    if (strpos($this->V82e89bfbf8b0b8c2424e5e654b00b8, "mssql") !== false)
                        $V9e3669d19b675bd57058fd4664205d = utf8_decode($V9e3669d19b675bd57058fd4664205d);
                    $V93355a2645d8b9343b2d2fc748fafd = 0;
                    if (strpos($V9e3669d19b675bd57058fd4664205d, "!=") === 0 || strpos($V9e3669d19b675bd57058fd4664205d, ">=") === 0 || strpos($V9e3669d19b675bd57058fd4664205d, "<=") === 0)
                        $V93355a2645d8b9343b2d2fc748fafd = 2;
                    else if (strpos($V9e3669d19b675bd57058fd4664205d, "=") === 0 || strpos($V9e3669d19b675bd57058fd4664205d, ">") === 0 || strpos($V9e3669d19b675bd57058fd4664205d, "<") === 0)
                        $V93355a2645d8b9343b2d2fc748fafd = 1;
                    if ($V93355a2645d8b9343b2d2fc748fafd > 0) {
                        $Vd3975204d927c2eabbeb7272cc7548 = substr($V9e3669d19b675bd57058fd4664205d, 0, $V93355a2645d8b9343b2d2fc748fafd);
                        $Vc16b193bd04a52da28f2e6c8cf713f = substr($V9e3669d19b675bd57058fd4664205d, $V93355a2645d8b9343b2d2fc748fafd);
                        if (!is_numeric($Vc16b193bd04a52da28f2e6c8cf713f))
                            continue;
                        $V9e3669d19b675bd57058fd4664205d = " $Vd3975204d927c2eabbeb7272cc7548 $Vc16b193bd04a52da28f2e6c8cf713f";
                        $V11d8c28a64490a987612f233250246 = 'inline';
                        $Vcca5019fe7f1443635095966d2a91c['inline'] = '';
                    } if (isset($V9e3669d19b675bd57058fd4664205d) && isset($V11d8c28a64490a987612f233250246)) {
                        $V865c0c0b4ab0e063e5caa3387c1a87++;
                        $V9e3669d19b675bd57058fd4664205d = $this->to_sql($V06e3d36fa30cea095545139854ad1f, $V11d8c28a64490a987612f233250246, $V9e3669d19b675bd57058fd4664205d);
                        if ($V865c0c0b4ab0e063e5caa3387c1a87 == 1)
                            $V48c03a144a8065f6d4e23bd63008be = " AND ";
                        else
                            $V48c03a144a8065f6d4e23bd63008be .= " " . $Ved780ed8cfdb7ec7cb361f834350ac . " ";
                        switch ($V11d8c28a64490a987612f233250246) {
                            case 'in' : case 'ni' : $V48c03a144a8065f6d4e23bd63008be .= $V06e3d36fa30cea095545139854ad1f . $Vcca5019fe7f1443635095966d2a91c[$V11d8c28a64490a987612f233250246] . " (" . $V9e3669d19b675bd57058fd4664205d . ")";
                                break;
                            case 'cn' : $V48c03a144a8065f6d4e23bd63008be .= $V06e3d36fa30cea095545139854ad1f . $Vcca5019fe7f1443635095966d2a91c[$V11d8c28a64490a987612f233250246] . $V9e3669d19b675bd57058fd4664205d;
                                break;
                            case 'bw' : $V48c03a144a8065f6d4e23bd63008be .= "LOWER($V06e3d36fa30cea095545139854ad1f)" . $Vcca5019fe7f1443635095966d2a91c[$V11d8c28a64490a987612f233250246] . " LOWER(" . $V9e3669d19b675bd57058fd4664205d . ")";
                                break;
                            case 'nn' : case 'nu' : $V48c03a144a8065f6d4e23bd63008be .= $V06e3d36fa30cea095545139854ad1f . $Vcca5019fe7f1443635095966d2a91c[$V11d8c28a64490a987612f233250246];
                                break;
                            default: $V48c03a144a8065f6d4e23bd63008be .= $V06e3d36fa30cea095545139854ad1f . $Vcca5019fe7f1443635095966d2a91c[$V11d8c28a64490a987612f233250246] . $V9e3669d19b675bd57058fd4664205d;
                        }
                    }
                }
            }
        } return $V48c03a144a8065f6d4e23bd63008be;
    }

    private function to_sql($V06e3d36fa30cea095545139854ad1f, $oper, $V3a6d0284e743dc4a9b86f97d6dd1a3) {
        if ($oper == 'bw' || $oper == 'bn')
            return "'" . addslashes($V3a6d0284e743dc4a9b86f97d6dd1a3) . "%'";
        else if ($oper == 'ew' || $oper == 'en')
            return "'%" . addcslashes($V3a6d0284e743dc4a9b86f97d6dd1a3) . "'";
        else if ($oper == 'cn' || $oper == 'nc')
            return "'%" . addslashes($V3a6d0284e743dc4a9b86f97d6dd1a3) . "%'";
        else if ($oper == 'inline')
            return addslashes($V3a6d0284e743dc4a9b86f97d6dd1a3);
        else if ($oper == 'in' || $oper == 'ni') {
            $V3a6d0284e743dc4a9b86f97d6dd1a3 = "'" . implode("','", explode(",", addslashes($V3a6d0284e743dc4a9b86f97d6dd1a3))) . "'";
            return $V3a6d0284e743dc4a9b86f97d6dd1a3;
        } else
            return "'" . addslashes($V3a6d0284e743dc4a9b86f97d6dd1a3) . "'";
    }

    function set_actions($V47c80780ab608cc046f2a6e6f071fe) {
        if (empty($V47c80780ab608cc046f2a6e6f071fe))
            $V47c80780ab608cc046f2a6e6f071fe = array();
        if (empty($this->actions))
            $this->actions = array();
        foreach ($V47c80780ab608cc046f2a6e6f071fe as $V8ce4b16b22b58894aa86c421e8759d => $V9e3669d19b675bd57058fd4664205d)
            if (is_array($V9e3669d19b675bd57058fd4664205d)) {
                if (!isset($this->actions[$V8ce4b16b22b58894aa86c421e8759d]))
                    $this->actions[$V8ce4b16b22b58894aa86c421e8759d] = array();
                $V47c80780ab608cc046f2a6e6f071fe[$V8ce4b16b22b58894aa86c421e8759d] = array_merge($V47c80780ab608cc046f2a6e6f071fe[$V8ce4b16b22b58894aa86c421e8759d], $this->actions[$V8ce4b16b22b58894aa86c421e8759d]);
            } $this->actions = array_merge($this->actions, $V47c80780ab608cc046f2a6e6f071fe);
    }

    function set_options($options) {
        if (empty($V47c80780ab608cc046f2a6e6f071fe))
            $V47c80780ab608cc046f2a6e6f071fe = array();
        if (empty($this->options))
            $this->options = array();
        if (isset($options["rowList"]))
            unset($this->options["rowList"]);
        foreach ($options as $V8ce4b16b22b58894aa86c421e8759d => $V9e3669d19b675bd57058fd4664205d)
            if (is_array($V9e3669d19b675bd57058fd4664205d)) {
                if (!isset($this->options[$V8ce4b16b22b58894aa86c421e8759d]))
                    $this->options[$V8ce4b16b22b58894aa86c421e8759d] = array();
                $options[$V8ce4b16b22b58894aa86c421e8759d] = array_merge($this->options[$V8ce4b16b22b58894aa86c421e8759d], $options[$V8ce4b16b22b58894aa86c421e8759d]);
            } $this->options = array_merge($this->options, $options);
        $this->options["editurl"] = $this->options["url"];
        $this->options["cellurl"] = $this->options["url"];
        $Vd89018e3792bceaf431470e413445a = '';
        if ($this->options["form"]["nav"] === true) {
            $Vd89018e3792bceaf431470e413445a = 'setTimeout(function(){jQuery("#pData").show();jQuery("#nData").show();},100);';
        } else {
            $Vd89018e3792bceaf431470e413445a = 'setTimeout(function(){jQuery("#pData").hide();jQuery("#nData").hide();},100);';
        } $this->Vd1efad72dc5b17dc66a46767c32fff["add_options"]["beforeShowForm"] = $Vd89018e3792bceaf431470e413445a;
        $this->Vd1efad72dc5b17dc66a46767c32fff["edit_options"]["beforeShowForm"] = $Vd89018e3792bceaf431470e413445a;
        $this->Vd1efad72dc5b17dc66a46767c32fff["delete_options"]["beforeShowForm"] = $Vd89018e3792bceaf431470e413445a;
        if (isset($this->options["toolbar"]) && $this->options["toolbar"] != "bottom") {
            $this->options["toppager"] = true;
            if ($this->options["hiddengrid"] == true && $this->options["toolbar"] == "top")
                $this->options["toolbar"] = "both";
        } if ($this->options["form"]["position"] == "center") {
            $V8056768f294a59690ab43daa1a46b9 = ($this->options["add_options"]["jqModal"] == false) ? "fixed" : "abs";
            $this->Vd1efad72dc5b17dc66a46767c32fff["add_options"]["beforeShowForm"] .= ' var gid = formid.attr("id").replace("FrmGrid_","");			jQuery("#editmod" + gid).' . $V8056768f294a59690ab43daa1a46b9 . 'center(); ';
            $V8056768f294a59690ab43daa1a46b9 = ($this->options["edit_options"]["jqModal"] == false) ? "fixed" : "abs";
            $this->Vd1efad72dc5b17dc66a46767c32fff["edit_options"]["beforeShowForm"] .= ' var gid = formid.attr("id").replace("FrmGrid_","");			jQuery("#editmod" + gid).' . $V8056768f294a59690ab43daa1a46b9 . 'center(); ';
            $V8056768f294a59690ab43daa1a46b9 = ($this->options["delete_options"]["jqModal"] == false) ? "fixed" : "abs";
            $this->Vd1efad72dc5b17dc66a46767c32fff["delete_options"]["beforeShowForm"] .= ' var gid = formid.attr("id").replace("DelTbl_","");			jQuery("#delmod" + gid).' . $V8056768f294a59690ab43daa1a46b9 . 'center(); ';
            $V8056768f294a59690ab43daa1a46b9 = ($this->options["view_options"]["jqModal"] == false) ? "fixed" : "abs";
            $this->Vd1efad72dc5b17dc66a46767c32fff["view_options"]["beforeShowForm"] .= ' var gid = formid.attr("id").replace("ViewGrid_","");			jQuery("#viewmod" + gid).' . $V8056768f294a59690ab43daa1a46b9 . 'center(); ';
            $V8056768f294a59690ab43daa1a46b9 = ($this->options["search_options"]["jqModal"] == false) ? "fixed" : "abs";
            $this->options["search_options"]["beforeShowSearch"] .= 'function(formid) { if (!formid.attr("id")) return true;			var gid = formid.attr("id").replace("fbox_",""); jQuery("#searchmodfbox_" + gid).' . $V8056768f294a59690ab43daa1a46b9 . 'center();			} ';
            unset($this->options["form"]["position"]);
        } if ($this->options["actionicon"] !== false) {
            $this->Vd1efad72dc5b17dc66a46767c32fff["actionicon"] = false;
            unset($this->options["actionicon"]);
        } if ($this->options["multiselect"] == true) {
            $this->options["beforeSelectRow"] = "function(rowid, e) 			 { var grid = jQuery(this), rows = this.rows, startId = grid.jqGrid('getGridParam', 'selrow'), startRow, endRow, iStart, iEnd, i, rowidIndex;			if (!e.ctrlKey && !e.shiftKey) { } else if (startId && e.shiftKey) { startRow = rows.namedItem(startId);			endRow = rows.namedItem(rowid); if (startRow && endRow) { iStart = Math.min(startRow.rowIndex, endRow.rowIndex);			rowidIndex = endRow.rowIndex; iEnd = Math.max(startRow.rowIndex, rowidIndex); var selected = grid.jqGrid('getGridParam','selarrrow');			for (i = iStart; i <= iEnd; i++) { if(selected.indexOf(rows[i].id) < 0 && i != rowidIndex) { 			 grid.jqGrid('setSelection', rows[i].id, true); } } } if(document.selection && document.selection.empty) 			 { document.selection.empty(); } else if(window.getSelection) { window.getSelection().removeAllRanges();			} } return true; }";
        }
    }

    function set_columns($V07d43db2a74336dcfbdaeeeffe6f7a = null) {
        if (!is_array($this->table) && !$this->table && !$this->select_command)
            die("Please specify tablename or select command");
        if (is_array($this->table)) {
            $V47c80780ab608cc046f2a6e6f071fe = $this->table;
            $V8fa14cdd754f91cc6554c9e71929cc = array_keys($V47c80780ab608cc046f2a6e6f071fe[0]);
        } else {
            if (!$this->select_command && $this->table)
                $this->select_command = "SELECT * FROM " . $this->table;
            if (stristr($this->select_command, "WHERE") === false) {
                if (($V83878c91171338902e0fe0fb97a8c4 = stripos($this->select_command, "GROUP BY")) !== false) {
                    $Vea2b2676c28c0db26d39331a336c6b = substr($this->select_command, 0, $V83878c91171338902e0fe0fb97a8c4);
                    $V7f021a1415b86f2d013b2618fb31ae = substr($this->select_command, $V83878c91171338902e0fe0fb97a8c4);
                    $this->select_command = $Vea2b2676c28c0db26d39331a336c6b . " WHERE 1=1 " . $V7f021a1415b86f2d013b2618fb31ae;
                } else
                    $this->select_command .= " WHERE 1=1";
            } $this->select_command = preg_replace("/(\r|\n)/", " ", $this->select_command);
            $this->select_command = preg_replace("/[ ]+/", " ", $this->select_command);
            if (!empty($this->Vd1efad72dc5b17dc66a46767c32fff["sql"]))
                $this->select_command = $this->Vd1efad72dc5b17dc66a46767c32fff["sql"];
            $Vac5c74b64b4b8352ef2f181affb5ac = $this->select_command . " LIMIT 1 OFFSET 0";
            $Vac5c74b64b4b8352ef2f181affb5ac = $this->Fe9b3c79462166409c20167747931ab($Vac5c74b64b4b8352ef2f181affb5ac, $this->V82e89bfbf8b0b8c2424e5e654b00b8);
            $Vb4a88417b3d0170d754c647c30b721 = $this->execute_query($Vac5c74b64b4b8352ef2f181affb5ac);
            if ($this->V7ed201fa20d25d22b291dc85ae9e5c) {
                $V47c80780ab608cc046f2a6e6f071fe = $Vb4a88417b3d0170d754c647c30b721->FetchRow();
                if (!empty($V47c80780ab608cc046f2a6e6f071fe))
                    foreach ($V47c80780ab608cc046f2a6e6f071fe as $V8ce4b16b22b58894aa86c421e8759d => $V3a2d7564baee79182ebc7b65084aab)
                        $V8fa14cdd754f91cc6554c9e71929cc[] = $V8ce4b16b22b58894aa86c421e8759d;
            } else {
                $Vb19f58c350bf81dca61000501f4c94 = mysql_num_fields($Vb4a88417b3d0170d754c647c30b721);
                for ($V865c0c0b4ab0e063e5caa3387c1a87 = 0; $V865c0c0b4ab0e063e5caa3387c1a87 < $Vb19f58c350bf81dca61000501f4c94; $V865c0c0b4ab0e063e5caa3387c1a87++) {
                    $V8fa14cdd754f91cc6554c9e71929cc[] = mysql_field_name($Vb4a88417b3d0170d754c647c30b721, $V865c0c0b4ab0e063e5caa3387c1a87);
                }
            }
        } if (!$V07d43db2a74336dcfbdaeeeffe6f7a) {
            foreach ($V8fa14cdd754f91cc6554c9e71929cc as $V4a8a08f09d37b73795649038408b5f) {
                $Vd89e2ddb530bb8953b290ab0793aec["title"] = ucwords(str_replace("_", " ", $V4a8a08f09d37b73795649038408b5f));
                $Vd89e2ddb530bb8953b290ab0793aec["name"] = $V4a8a08f09d37b73795649038408b5f;
                $Vd89e2ddb530bb8953b290ab0793aec["index"] = $V4a8a08f09d37b73795649038408b5f;
                $Vd89e2ddb530bb8953b290ab0793aec["editable"] = true;
                $Vd89e2ddb530bb8953b290ab0793aec["editoptions"] = array("size" => 20);
                $Vd89e2ddb530bb8953b290ab0793aec["searchoptions"]["clearSearch"] = false;
                $Vcb719520d76ebcd4964ec483f512f4[] = $Vd89e2ddb530bb8953b290ab0793aec;
            }
        } if (!$V07d43db2a74336dcfbdaeeeffe6f7a)
            $V07d43db2a74336dcfbdaeeeffe6f7a = $Vcb719520d76ebcd4964ec483f512f4;
        for ($V865c0c0b4ab0e063e5caa3387c1a87 = 0; $V865c0c0b4ab0e063e5caa3387c1a87 < count($V07d43db2a74336dcfbdaeeeffe6f7a); $V865c0c0b4ab0e063e5caa3387c1a87++) {
            $V07d43db2a74336dcfbdaeeeffe6f7a[$V865c0c0b4ab0e063e5caa3387c1a87]["name"] = $V07d43db2a74336dcfbdaeeeffe6f7a[$V865c0c0b4ab0e063e5caa3387c1a87]["name"];
            $V07d43db2a74336dcfbdaeeeffe6f7a[$V865c0c0b4ab0e063e5caa3387c1a87]["index"] = $V07d43db2a74336dcfbdaeeeffe6f7a[$V865c0c0b4ab0e063e5caa3387c1a87]["name"];
            $V07d43db2a74336dcfbdaeeeffe6f7a[$V865c0c0b4ab0e063e5caa3387c1a87]["searchoptions"]["clearSearch"] = false;
            if ($V07d43db2a74336dcfbdaeeeffe6f7a[$V865c0c0b4ab0e063e5caa3387c1a87]["editrules"]["required"] == true)
                $V07d43db2a74336dcfbdaeeeffe6f7a[$V865c0c0b4ab0e063e5caa3387c1a87]["formoptions"]["elmsuffix"] = '<font color=red> *</font>';
            if (isset($V07d43db2a74336dcfbdaeeeffe6f7a[$V865c0c0b4ab0e063e5caa3387c1a87]["formatter"]) && $V07d43db2a74336dcfbdaeeeffe6f7a[$V865c0c0b4ab0e063e5caa3387c1a87]["formatter"] == "date" && empty($V07d43db2a74336dcfbdaeeeffe6f7a[$V865c0c0b4ab0e063e5caa3387c1a87]["formatoptions"]))
                $V07d43db2a74336dcfbdaeeeffe6f7a[$V865c0c0b4ab0e063e5caa3387c1a87]["formatoptions"] = array("srcformat" => 'Y-m-d', "newformat" => 'Y-m-d');
            if (isset($V07d43db2a74336dcfbdaeeeffe6f7a[$V865c0c0b4ab0e063e5caa3387c1a87]["formatter"]) && $V07d43db2a74336dcfbdaeeeffe6f7a[$V865c0c0b4ab0e063e5caa3387c1a87]["formatter"] == "datetime" && empty($V07d43db2a74336dcfbdaeeeffe6f7a[$V865c0c0b4ab0e063e5caa3387c1a87]["formatoptions"]))
                $V07d43db2a74336dcfbdaeeeffe6f7a[$V865c0c0b4ab0e063e5caa3387c1a87]["formatoptions"] = array("srcformat" => 'Y-m-d H:i:s', "newformat" => 'Y-m-d H:i:s');
            $Vf387e314fe3d7a3eadf79aa76b228d = $V07d43db2a74336dcfbdaeeeffe6f7a[$V865c0c0b4ab0e063e5caa3387c1a87]["formatoptions"]["newformat"];
            if (isset($V07d43db2a74336dcfbdaeeeffe6f7a[$V865c0c0b4ab0e063e5caa3387c1a87]["stype"]) && $V07d43db2a74336dcfbdaeeeffe6f7a[$V865c0c0b4ab0e063e5caa3387c1a87]["stype"] == "select" && substr($V07d43db2a74336dcfbdaeeeffe6f7a[$V865c0c0b4ab0e063e5caa3387c1a87]["searchoptions"]["value"], 0, 2) !== ":;") {
                $V07d43db2a74336dcfbdaeeeffe6f7a[$V865c0c0b4ab0e063e5caa3387c1a87]["searchoptions"]["value"] = ":;" . $V07d43db2a74336dcfbdaeeeffe6f7a[$V865c0c0b4ab0e063e5caa3387c1a87]["searchoptions"]["value"];
            }
        } $V07d43db2a74336dcfbdaeeeffe6f7a[0]["key"] = true;
        $this->options["colModel"] = $V07d43db2a74336dcfbdaeeeffe6f7a;
        foreach ($V07d43db2a74336dcfbdaeeeffe6f7a as $V4a8a08f09d37b73795649038408b5f) {
            $this->options["colNames"][] = $V4a8a08f09d37b73795649038408b5f["title"];
        }
    }

    function execute_query($Vac5c74b64b4b8352ef2f181affb5ac, $return = "") {
        if ($this->V7ed201fa20d25d22b291dc85ae9e5c) {
            $V2cb9df9898e55fd0ad829dc202ddbd = $this->V7ed201fa20d25d22b291dc85ae9e5c->Execute($Vac5c74b64b4b8352ef2f181affb5ac);
            if (!$V2cb9df9898e55fd0ad829dc202ddbd) {
                if ($this->debug)
                    phpgrid_error("Couldn't execute query. " . $this->V7ed201fa20d25d22b291dc85ae9e5c->ErrorMsg() . " - $Vac5c74b64b4b8352ef2f181affb5ac");
                else
                    phpgrid_error($this->error_msg);
            } if ($return == "insert_id")
                return $this->V7ed201fa20d25d22b291dc85ae9e5c->Insert_ID();
        } else {
            $V2cb9df9898e55fd0ad829dc202ddbd = mysql_query($Vac5c74b64b4b8352ef2f181affb5ac);
            if (!$V2cb9df9898e55fd0ad829dc202ddbd) {
                if ($this->debug)
                    phpgrid_error("Couldn't execute query. " . mysql_error() . " - $Vac5c74b64b4b8352ef2f181affb5ac");
                else
                    phpgrid_error($this->error_msg);
            } if ($return == "insert_id")
                return mysql_insert_id();
        } return $V2cb9df9898e55fd0ad829dc202ddbd;
    }

    function render($grid_id) {
        $V0b43f80c13e3859aacf6f8ce506d63 = isset($_REQUEST["nd"]) || isset($_REQUEST["oper"]) || isset($_REQUEST["export"]);
        if ($V0b43f80c13e3859aacf6f8ce506d63 && $_REQUEST["grid_id"] != $grid_id)
            return;
        $V5376d5c86a03094c537b0ec41cd874 = (strpos($this->options["url"], "?") === false) ? "?" : "&";
        $this->options["url"] .= $V5376d5c86a03094c537b0ec41cd874 . "grid_id=$grid_id";
        $this->options["editurl"] .= $V5376d5c86a03094c537b0ec41cd874 . "grid_id=$grid_id";
        $this->options["cellurl"] .= $V5376d5c86a03094c537b0ec41cd874 . "grid_id=$grid_id";
        if (isset($_REQUEST["subgrid"])) {
            $grid_id = "_" . $_REQUEST["subgrid"];
        } $this->Vb80bb7740288fda1f201890375a60c = $grid_id;
        if (!$this->options["colNames"])
            $this->set_columns();
        if ($this->options["persistsearch"] === true) {
            $this->options["search"] = true;
            $this->options["postData"] = array("filters" => $_SESSION["jqgrid_{$grid_id}_searchstr"]);
            $Vcf49579f36ff409c5b0d877f0b50d6 = json_decode($_SESSION["jqgrid_{$grid_id}_searchstr"], true);
            foreach ($Vcf49579f36ff409c5b0d877f0b50d6["rules"] as &$Va4f86f7bfc24194b276c22e0ef1581) {
                foreach ($this->options["colModel"] as &$Vd89e2ddb530bb8953b290ab0793aec) {
                    if ($Va4f86f7bfc24194b276c22e0ef1581['field'] == $Vd89e2ddb530bb8953b290ab0793aec["name"]) {
                        $V9dad32e889ca81a9fa36b52204abb0 = $Va4f86f7bfc24194b276c22e0ef1581['data'];
                        $Vd89e2ddb530bb8953b290ab0793aec["searchoptions"] = array("defaultValue" => $V9dad32e889ca81a9fa36b52204abb0);
                    }
                }
            }
        } if (isset($_POST['oper'])) {
            $V11d8c28a64490a987612f233250246 = $_POST['oper'];
            $V8d777f385d3dfec8815d20f7496026 = $_POST;
            $V2dab5f16f5811c4813e6001831705e = $this->options["colModel"][0]["index"];
            $Vb80bb7740288fda1f201890375a60c = (isset($V8d777f385d3dfec8815d20f7496026[$V2dab5f16f5811c4813e6001831705e]) ? $V8d777f385d3dfec8815d20f7496026[$V2dab5f16f5811c4813e6001831705e] : $V8d777f385d3dfec8815d20f7496026["id"]);
            if (strpos($this->V82e89bfbf8b0b8c2424e5e654b00b8, "mssql") !== false)
                $V8d777f385d3dfec8815d20f7496026 = Ff30ab28a29f834c3e8f01000509956($V8d777f385d3dfec8815d20f7496026);
            $Vf5ed6ce729c5b7a821448a22eee308 = array();
            foreach ($this->options["colModel"] as $V4a8a08f09d37b73795649038408b5f) {
                if (!isset($V8d777f385d3dfec8815d20f7496026[$V4a8a08f09d37b73795649038408b5f["index"]]))
                    continue;
                if (strstr($V4a8a08f09d37b73795649038408b5f["formatoptions"]["newformat"], "D")) {
                    $V8d777f385d3dfec8815d20f7496026[$V4a8a08f09d37b73795649038408b5f["index"]] = str_ireplace(array("sun", "mon", "tue", "wed", "thu", "fri", "sat"), "", $V8d777f385d3dfec8815d20f7496026[$V4a8a08f09d37b73795649038408b5f["index"]]);
                    $V8d777f385d3dfec8815d20f7496026[$V4a8a08f09d37b73795649038408b5f["index"]] = trim($V8d777f385d3dfec8815d20f7496026[$V4a8a08f09d37b73795649038408b5f["index"]]);
                } if (strstr($V4a8a08f09d37b73795649038408b5f["formatoptions"]["newformat"], "d/m/Y")) {
                    $Vfa816edb83e95bf0c8da580bdfd491 = explode("/", $V8d777f385d3dfec8815d20f7496026[$V4a8a08f09d37b73795649038408b5f["index"]]);
                    $V8d777f385d3dfec8815d20f7496026[$V4a8a08f09d37b73795649038408b5f["index"]] = $Vfa816edb83e95bf0c8da580bdfd491[1] . "/" . $Vfa816edb83e95bf0c8da580bdfd491[0] . "/" . $Vfa816edb83e95bf0c8da580bdfd491[2];
                } if (($V4a8a08f09d37b73795649038408b5f["formatter"] == "date" || $V4a8a08f09d37b73795649038408b5f["formatter"] == "datetime") && (empty($V8d777f385d3dfec8815d20f7496026[$V4a8a08f09d37b73795649038408b5f["index"]]) || $V8d777f385d3dfec8815d20f7496026[$V4a8a08f09d37b73795649038408b5f["index"]] == "//")) {
                    $V8d777f385d3dfec8815d20f7496026[$V4a8a08f09d37b73795649038408b5f["index"]] = "NULL";
                } else if ($V4a8a08f09d37b73795649038408b5f["isnull"] && empty($V8d777f385d3dfec8815d20f7496026[$V4a8a08f09d37b73795649038408b5f["index"]])) {
                    $V8d777f385d3dfec8815d20f7496026[$V4a8a08f09d37b73795649038408b5f["index"]] = "NULL";
                } else if ($V4a8a08f09d37b73795649038408b5f["formatter"] == "date") {
                    $V8d777f385d3dfec8815d20f7496026[$V4a8a08f09d37b73795649038408b5f["index"]] = date("Y-m-d", strtotime($V8d777f385d3dfec8815d20f7496026[$V4a8a08f09d37b73795649038408b5f["index"]]));
                } else if ($V4a8a08f09d37b73795649038408b5f["formatter"] == "datetime") {
                    $V8d777f385d3dfec8815d20f7496026[$V4a8a08f09d37b73795649038408b5f["index"]] = date("Y-m-d H:i:s", strtotime($V8d777f385d3dfec8815d20f7496026[$V4a8a08f09d37b73795649038408b5f["index"]]));
                } else if ($V4a8a08f09d37b73795649038408b5f["formatter"] == "autocomplete" && $V4a8a08f09d37b73795649038408b5f["index"] != $V4a8a08f09d37b73795649038408b5f["formatoptions"]["update_field"]) {
                    unset($V8d777f385d3dfec8815d20f7496026[$V4a8a08f09d37b73795649038408b5f["index"]]);
                } else if ($V4a8a08f09d37b73795649038408b5f["formatter"] == "password" && $V8d777f385d3dfec8815d20f7496026[$V4a8a08f09d37b73795649038408b5f["index"]] == "*****") {
                    unset($V8d777f385d3dfec8815d20f7496026[$V4a8a08f09d37b73795649038408b5f["index"]]);
                } if ($V4a8a08f09d37b73795649038408b5f["isnum"] === true)
                    $Vf5ed6ce729c5b7a821448a22eee308[$V4a8a08f09d37b73795649038408b5f["index"]] = true;
            } switch ($V11d8c28a64490a987612f233250246) {
                case "add": if ($V2dab5f16f5811c4813e6001831705e != "id")
                        unset($V8d777f385d3dfec8815d20f7496026['id']);
                    unset($V8d777f385d3dfec8815d20f7496026['oper']);
                    $V74c9e6d400f4fa553b06943a9384e5 = array();
                    foreach ($V8d777f385d3dfec8815d20f7496026 as $V8ce4b16b22b58894aa86c421e8759d => $V9e3669d19b675bd57058fd4664205d) {
                        $V8ce4b16b22b58894aa86c421e8759d = addslashes($V8ce4b16b22b58894aa86c421e8759d);
                        $V9e3669d19b675bd57058fd4664205d = ($V9e3669d19b675bd57058fd4664205d == "NULL" || $Vf5ed6ce729c5b7a821448a22eee308[$V8ce4b16b22b58894aa86c421e8759d] === true) ? $V9e3669d19b675bd57058fd4664205d : "'$V9e3669d19b675bd57058fd4664205d'";
                        $Ve0320a589b79e556b50cacb6e86680[] = "$V9e3669d19b675bd57058fd4664205d";
                        if (strpos($this->V82e89bfbf8b0b8c2424e5e654b00b8, "mysql") !== false || !isset($this->V82e89bfbf8b0b8c2424e5e654b00b8))
                            $V8ce4b16b22b58894aa86c421e8759d = "`$V8ce4b16b22b58894aa86c421e8759d`";
                        if (strpos($this->V82e89bfbf8b0b8c2424e5e654b00b8, "mssql") !== false)
                            $V9e3669d19b675bd57058fd4664205d = $this->Fd280460c57fe7dec4bf2ebe324999f($V9e3669d19b675bd57058fd4664205d);
                        else
                            $V9e3669d19b675bd57058fd4664205d = addslashes($V9e3669d19b675bd57058fd4664205d);
                        $Vd1548b8d1ec5c928b5ec896bca9c0b[] = "$V8ce4b16b22b58894aa86c421e8759d";
                    } $Va5dbc0145cccdf0cd22d556c895754 = "(" . implode(",", $Vd1548b8d1ec5c928b5ec896bca9c0b) . ") VALUES (" . implode(",", $Ve0320a589b79e556b50cacb6e86680) . ")";
                    $Vac5c74b64b4b8352ef2f181affb5ac = "INSERT INTO {$this->table} $Va5dbc0145cccdf0cd22d556c895754";
                    $V2e574ab0ad48a282bb7bb5b7848b79 = $this->execute_query($Vac5c74b64b4b8352ef2f181affb5ac, "insert_id");
                    if ($Vb80bb7740288fda1f201890375a60c == "new_row")
                        die($V2dab5f16f5811c4813e6001831705e . "#" . $V2e574ab0ad48a282bb7bb5b7848b79);
                    if (intval($V2e574ab0ad48a282bb7bb5b7848b79) > 0)
                        $V9b207167e5381c47682c6b4f58a623 = array("id" => $V2e574ab0ad48a282bb7bb5b7848b79, "success" => true);
                    else
                        $V9b207167e5381c47682c6b4f58a623 = array("id" => 0, "success" => false);
                    echo json_encode($V9b207167e5381c47682c6b4f58a623);
                    break;
                case "edit": if ($V2dab5f16f5811c4813e6001831705e != "id")
                        unset($V8d777f385d3dfec8815d20f7496026['id']);
                    unset($V8d777f385d3dfec8815d20f7496026['oper']);
                    $V74c9e6d400f4fa553b06943a9384e5 = array();
                    foreach ($V8d777f385d3dfec8815d20f7496026 as $V8ce4b16b22b58894aa86c421e8759d => $V9e3669d19b675bd57058fd4664205d) {
                        $V8ce4b16b22b58894aa86c421e8759d = addslashes($V8ce4b16b22b58894aa86c421e8759d);
                        if (strpos($this->V82e89bfbf8b0b8c2424e5e654b00b8, "mysql") !== false || !isset($this->V82e89bfbf8b0b8c2424e5e654b00b8))
                            $V8ce4b16b22b58894aa86c421e8759d = "`$V8ce4b16b22b58894aa86c421e8759d`";
                        if (strpos($this->V82e89bfbf8b0b8c2424e5e654b00b8, "mssql") !== false)
                            $V9e3669d19b675bd57058fd4664205d = $this->Fd280460c57fe7dec4bf2ebe324999f($V9e3669d19b675bd57058fd4664205d);
                        else
                            $V9e3669d19b675bd57058fd4664205d = addslashes($V9e3669d19b675bd57058fd4664205d);
                        if (strstr($Vb80bb7740288fda1f201890375a60c, ",") !== false && ($V9e3669d19b675bd57058fd4664205d === "" || $V9e3669d19b675bd57058fd4664205d == "NULL"))
                            continue;
                        $V9e3669d19b675bd57058fd4664205d = ($V9e3669d19b675bd57058fd4664205d == "NULL" || $Vf5ed6ce729c5b7a821448a22eee308[$V8ce4b16b22b58894aa86c421e8759d] === true) ? $V9e3669d19b675bd57058fd4664205d : "'$V9e3669d19b675bd57058fd4664205d'";
                        $V74c9e6d400f4fa553b06943a9384e5[] = "$V8ce4b16b22b58894aa86c421e8759d=$V9e3669d19b675bd57058fd4664205d";
                    } $V74c9e6d400f4fa553b06943a9384e5 = "SET " . implode(",", $V74c9e6d400f4fa553b06943a9384e5);
                    $Vb80bb7740288fda1f201890375a60c = "'" . implode("','", explode(",", $Vb80bb7740288fda1f201890375a60c)) . "'";
                    $Vac5c74b64b4b8352ef2f181affb5ac = "UPDATE {$this->table} $V74c9e6d400f4fa553b06943a9384e5 WHERE $V2dab5f16f5811c4813e6001831705e IN ($Vb80bb7740288fda1f201890375a60c)";
                    $V2cb9df9898e55fd0ad829dc202ddbd = $this->execute_query($Vac5c74b64b4b8352ef2f181affb5ac);
                    if ($V2cb9df9898e55fd0ad829dc202ddbd)
                        $V9b207167e5381c47682c6b4f58a623 = array("id" => $Vb80bb7740288fda1f201890375a60c, "success" => true);
                    else
                        $V9b207167e5381c47682c6b4f58a623 = array("id" => 0, "success" => false);
                    echo json_encode($V9b207167e5381c47682c6b4f58a623);
                    break;
                case "del": $Vb80bb7740288fda1f201890375a60c = $V8d777f385d3dfec8815d20f7496026["id"];
                    $Vb80bb7740288fda1f201890375a60c = "'" . implode("','", explode(",", $Vb80bb7740288fda1f201890375a60c)) . "'";
                    $Vac5c74b64b4b8352ef2f181affb5ac = "DELETE FROM {$this->table} WHERE $V2dab5f16f5811c4813e6001831705e IN ($Vb80bb7740288fda1f201890375a60c)";
                    $this->execute_query($Vac5c74b64b4b8352ef2f181affb5ac);
                    break;
            } die;
        } $V6148bbf9dee45483f94f992b0b7c7a = "";
        if (!isset($_REQUEST['_search']))
            $_REQUEST['_search'] = "";
        $V9d9a9e7dbb34ad6643456a9fee1cb6 = $this->strip($_REQUEST['_search']);
        if ($V9d9a9e7dbb34ad6643456a9fee1cb6 == 'true') {
            $V39b7b22d803b1a0270c9c6c6f8a3b4 = $this->strip($_REQUEST['searchField']);
            $V07d43db2a74336dcfbdaeeeffe6f7a = array();
            foreach ($this->options["colModel"] as $Vd89e2ddb530bb8953b290ab0793aec)
                $V07d43db2a74336dcfbdaeeeffe6f7a[] = $Vd89e2ddb530bb8953b290ab0793aec["index"];
            if (!$V39b7b22d803b1a0270c9c6c6f8a3b4) {
                $V29d719b2519d8bbea5ae9a277cc57d = $this->strip($_REQUEST['filters']);
                $_SESSION["jqgrid_{$this->Vb80bb7740288fda1f201890375a60c}_searchstr"] = $V29d719b2519d8bbea5ae9a277cc57d;
                $V6148bbf9dee45483f94f992b0b7c7a = $this->construct_where($V29d719b2519d8bbea5ae9a277cc57d);
            } else {
                if (in_array($V39b7b22d803b1a0270c9c6c6f8a3b4, $V07d43db2a74336dcfbdaeeeffe6f7a)) {
                    $V930b8af83ba913154dadcc2dc0e0b5 = $this->strip($_REQUEST['searchString']);
                    $V2acdba1683a3fa23a4c27c16753dc3 = $this->strip($_REQUEST['searchOper']);
                    $V6148bbf9dee45483f94f992b0b7c7a .= " AND " . $V39b7b22d803b1a0270c9c6c6f8a3b4;
                    switch ($V2acdba1683a3fa23a4c27c16753dc3) {
                        case "eq": if (is_numeric($V930b8af83ba913154dadcc2dc0e0b5)) {
                                $V6148bbf9dee45483f94f992b0b7c7a .= " = " . $V930b8af83ba913154dadcc2dc0e0b5;
                            } else {
                                $V6148bbf9dee45483f94f992b0b7c7a .= " = '" . $V930b8af83ba913154dadcc2dc0e0b5 . "'";
                            } break;
                        case "ne": if (is_numeric($V930b8af83ba913154dadcc2dc0e0b5)) {
                                $V6148bbf9dee45483f94f992b0b7c7a .= " <> " . $V930b8af83ba913154dadcc2dc0e0b5;
                            } else {
                                $V6148bbf9dee45483f94f992b0b7c7a .= " <> '" . $V930b8af83ba913154dadcc2dc0e0b5 . "'";
                            } break;
                        case "lt": if (is_numeric($V930b8af83ba913154dadcc2dc0e0b5)) {
                                $V6148bbf9dee45483f94f992b0b7c7a .= " < " . $V930b8af83ba913154dadcc2dc0e0b5;
                            } else {
                                $V6148bbf9dee45483f94f992b0b7c7a .= " < '" . $V930b8af83ba913154dadcc2dc0e0b5 . "'";
                            } break;
                        case "le": if (is_numeric($V930b8af83ba913154dadcc2dc0e0b5)) {
                                $V6148bbf9dee45483f94f992b0b7c7a .= " <= " . $V930b8af83ba913154dadcc2dc0e0b5;
                            } else {
                                $V6148bbf9dee45483f94f992b0b7c7a .= " <= '" . $V930b8af83ba913154dadcc2dc0e0b5 . "'";
                            } break;
                        case "gt": if (is_numeric($V930b8af83ba913154dadcc2dc0e0b5)) {
                                $V6148bbf9dee45483f94f992b0b7c7a .= " > " . $V930b8af83ba913154dadcc2dc0e0b5;
                            } else {
                                $V6148bbf9dee45483f94f992b0b7c7a .= " > '" . $V930b8af83ba913154dadcc2dc0e0b5 . "'";
                            } break;
                        case "ge": if (is_numeric($V930b8af83ba913154dadcc2dc0e0b5)) {
                                $V6148bbf9dee45483f94f992b0b7c7a .= " >= " . $V930b8af83ba913154dadcc2dc0e0b5;
                            } else {
                                $V6148bbf9dee45483f94f992b0b7c7a .= " >= '" . $V930b8af83ba913154dadcc2dc0e0b5 . "'";
                            } break;
                        case "ew": $V6148bbf9dee45483f94f992b0b7c7a .= " LIKE '%" . $V930b8af83ba913154dadcc2dc0e0b5 . "'";
                            break;
                        case "en": $V6148bbf9dee45483f94f992b0b7c7a .= " NOT LIKE '%" . $V930b8af83ba913154dadcc2dc0e0b5 . "'";
                            break;
                        case "cn": $V6148bbf9dee45483f94f992b0b7c7a .= " LIKE '%" . $V930b8af83ba913154dadcc2dc0e0b5 . "%'";
                            break;
                        case "nc": $V6148bbf9dee45483f94f992b0b7c7a .= " NOT LIKE '%" . $V930b8af83ba913154dadcc2dc0e0b5 . "%'";
                            break;
                        case "in": $V6148bbf9dee45483f94f992b0b7c7a .= " IN (" . $V930b8af83ba913154dadcc2dc0e0b5 . ")";
                            break;
                        case "ni": $V6148bbf9dee45483f94f992b0b7c7a .= " NOT IN (" . $V930b8af83ba913154dadcc2dc0e0b5 . ")";
                            break;
                        case "nu": $V6148bbf9dee45483f94f992b0b7c7a .= " IS NULL";
                            break;
                        case "nn": $V6148bbf9dee45483f94f992b0b7c7a .= " IS NOT NULL";
                            break;
                        case "bw": default: $V930b8af83ba913154dadcc2dc0e0b5 .= "%";
                            $V6148bbf9dee45483f94f992b0b7c7a .= " LIKE '" . $V930b8af83ba913154dadcc2dc0e0b5 . "'";
                            break;
                    }
                }
            } $_SESSION["jqgrid_{$grid_id}_filter"] = $V6148bbf9dee45483f94f992b0b7c7a;
            $_SESSION["jqgrid_{$grid_id}_filter_request"] = $_REQUEST["filters"];
        } elseif ($V9d9a9e7dbb34ad6643456a9fee1cb6 == 'false') {
            unset($_SESSION["jqgrid_{$grid_id}_filter"]);
            unset($_SESSION["jqgrid_{$grid_id}_filter_request"]);
        } if (isset($_GET['jqgrid_page'])) {
            $page = $_GET['jqgrid_page'];
            $Vaa9f73eea60a006820d0f8768bc8a3 = $_GET['rows'];
            $sidx = $_GET['sidx'];
            $sord = $_GET['sord'];
            if (!$sidx)
                $sidx = 1;
            if (!$Vaa9f73eea60a006820d0f8768bc8a3)
                $Vaa9f73eea60a006820d0f8768bc8a3 = 20;
            if (isset($_GET["export"])) {
                $sidx = $_SESSION["jqgrid_{$grid_id}_sort_by"];
                $sord = $_SESSION["jqgrid_{$grid_id}_sort_order"];
                $Vaa9f73eea60a006820d0f8768bc8a3 = $_SESSION["jqgrid_{$grid_id}_rows"];
            } else {
                $_SESSION["jqgrid_{$grid_id}_sort_by"] = $sidx;
                $_SESSION["jqgrid_{$grid_id}_sort_order"] = $sord;
                $_SESSION["jqgrid_{$grid_id}_rows"] = $Vaa9f73eea60a006820d0f8768bc8a3;
            } if (!empty($this->Vd1efad72dc5b17dc66a46767c32fff["sql_count"])) {
                $Vc89ab23398f486d0df6dc8ad44ae1d = $this->Vd1efad72dc5b17dc66a46767c32fff["sql_count"];
            } else if (!empty($this->select_count)) {
                $Vc89ab23398f486d0df6dc8ad44ae1d = $this->select_count . $V6148bbf9dee45483f94f992b0b7c7a;
            } else if (($V83878c91171338902e0fe0fb97a8c4 = stripos($this->select_command, "GROUP BY")) !== false) {
                $Vc89ab23398f486d0df6dc8ad44ae1d = $this->select_command;
                $V83878c91171338902e0fe0fb97a8c4 = stripos($Vc89ab23398f486d0df6dc8ad44ae1d, "GROUP BY");
                $V4f50fef9d9813625aa9e2de6c50dcf = substr($Vc89ab23398f486d0df6dc8ad44ae1d, 0, $V83878c91171338902e0fe0fb97a8c4);
                $V00928fab2ed25c2227100256706840 = substr($Vc89ab23398f486d0df6dc8ad44ae1d, $V83878c91171338902e0fe0fb97a8c4);
                $Vc89ab23398f486d0df6dc8ad44ae1d = "SELECT count(*) as c FROM ($V4f50fef9d9813625aa9e2de6c50dcf $V6148bbf9dee45483f94f992b0b7c7a $V00928fab2ed25c2227100256706840) pg_tmp";
            } else {
                $Vc89ab23398f486d0df6dc8ad44ae1d = $this->select_command . $V6148bbf9dee45483f94f992b0b7c7a;
                $Vc89ab23398f486d0df6dc8ad44ae1d = "SELECT count(*) as c FROM (" . $Vc89ab23398f486d0df6dc8ad44ae1d . ") pg_tmp";
            } $Vb4a88417b3d0170d754c647c30b721 = $this->execute_query($Vc89ab23398f486d0df6dc8ad44ae1d);
            if ($this->V7ed201fa20d25d22b291dc85ae9e5c) {
                $Vf1965a857bc285d26fe22023aa5ab5 = $Vb4a88417b3d0170d754c647c30b721->FetchRow();
            } else {
                $Vf1965a857bc285d26fe22023aa5ab5 = mysql_fetch_array($Vb4a88417b3d0170d754c647c30b721, MYSQL_ASSOC);
            } $Ve2942a04780e223b215eb8b663cf53 = $Vf1965a857bc285d26fe22023aa5ab5['c'];
            if (empty($Ve2942a04780e223b215eb8b663cf53))
                $Ve2942a04780e223b215eb8b663cf53 = $Vf1965a857bc285d26fe22023aa5ab5['C'];
            if ($Ve2942a04780e223b215eb8b663cf53 > 0) {
                $Vae0fe0cc7e778fabf61f9217886eb3 = ceil($Ve2942a04780e223b215eb8b663cf53 / $Vaa9f73eea60a006820d0f8768bc8a3);
            } else {
                $Vae0fe0cc7e778fabf61f9217886eb3 = 0;
            } if ($page > $Vae0fe0cc7e778fabf61f9217886eb3)
                $page = $Vae0fe0cc7e778fabf61f9217886eb3;
            $Vea2b2676c28c0db26d39331a336c6b = $Vaa9f73eea60a006820d0f8768bc8a3 * $page - $Vaa9f73eea60a006820d0f8768bc8a3;
            if ($Vea2b2676c28c0db26d39331a336c6b < 0)
                $Vea2b2676c28c0db26d39331a336c6b = 0;
            $Vfb5270b9d9076a4df05bfce5b30d43 = new stdClass();
            $Vfb5270b9d9076a4df05bfce5b30d43->page = $page;
            $Vfb5270b9d9076a4df05bfce5b30d43->total = $Vae0fe0cc7e778fabf61f9217886eb3;
            $Vfb5270b9d9076a4df05bfce5b30d43->records = $Ve2942a04780e223b215eb8b663cf53;
            if (!empty($this->Vd1efad72dc5b17dc66a46767c32fff["sql"])) {
                $V9778840a0100cb30c982876741b0b5 = $this->Vd1efad72dc5b17dc66a46767c32fff["sql"] . " LIMIT $Vaa9f73eea60a006820d0f8768bc8a3 OFFSET $Vea2b2676c28c0db26d39331a336c6b";
            } else if (($V83878c91171338902e0fe0fb97a8c4 = stripos($this->select_command, "GROUP BY")) !== false) {
                $V4f50fef9d9813625aa9e2de6c50dcf = substr($this->select_command, 0, $V83878c91171338902e0fe0fb97a8c4);
                $V00928fab2ed25c2227100256706840 = substr($this->select_command, $V83878c91171338902e0fe0fb97a8c4);
                $V9778840a0100cb30c982876741b0b5 = "$V4f50fef9d9813625aa9e2de6c50dcf $V6148bbf9dee45483f94f992b0b7c7a $V00928fab2ed25c2227100256706840 ORDER BY $sidx $sord LIMIT $Vaa9f73eea60a006820d0f8768bc8a3 OFFSET $Vea2b2676c28c0db26d39331a336c6b";
            } else {
                $V9778840a0100cb30c982876741b0b5 = $this->select_command . $V6148bbf9dee45483f94f992b0b7c7a . " ORDER BY $sidx $sord LIMIT $Vaa9f73eea60a006820d0f8768bc8a3 OFFSET $Vea2b2676c28c0db26d39331a336c6b";
            } $V9778840a0100cb30c982876741b0b5 = $this->Fe9b3c79462166409c20167747931ab($V9778840a0100cb30c982876741b0b5, $this->V82e89bfbf8b0b8c2424e5e654b00b8);
            $Vb4a88417b3d0170d754c647c30b721 = $this->execute_query($V9778840a0100cb30c982876741b0b5);
            if ($this->V7ed201fa20d25d22b291dc85ae9e5c) {
                $rows = $Vb4a88417b3d0170d754c647c30b721->GetRows();
                if (count($rows) > $Vaa9f73eea60a006820d0f8768bc8a3)
                    $rows = array_slice($rows, count($rows) - $Vaa9f73eea60a006820d0f8768bc8a3);
            } else {
                $rows = array();
                while ($Vf1965a857bc285d26fe22023aa5ab5 = mysql_fetch_array($Vb4a88417b3d0170d754c647c30b721, MYSQL_ASSOC))
                    $rows[] = $Vf1965a857bc285d26fe22023aa5ab5;
            } if (!empty($rows["userdata"])) {
                $V08fd04da1b9c3e4c1c9ab1fe42494a = $rows["userdata"];
                unset($rows["userdata"]);
            } foreach ($rows as $Vf1965a857bc285d26fe22023aa5ab5) {
                $Vbbdbcdcf08d55a84fb2d3b511c7a9b = $Vf1965a857bc285d26fe22023aa5ab5;
                foreach ($this->options["colModel"] as $V4a8a08f09d37b73795649038408b5f) {
                    $V6f6c99bba6081f21f3f0b75ee98cf5 = $V4a8a08f09d37b73795649038408b5f["name"];
                    if (!empty($V4a8a08f09d37b73795649038408b5f["link"])) {
                        foreach ($this->options["colModel"] as $V73d4fc339cd9a5a0e79143fd3fc999) {
                            if (strstr($Vbbdbcdcf08d55a84fb2d3b511c7a9b[$V73d4fc339cd9a5a0e79143fd3fc999["name"]], "http://"))
                                $Vf32353ea4a4bf46b014307995b4215 = $Vbbdbcdcf08d55a84fb2d3b511c7a9b[$V73d4fc339cd9a5a0e79143fd3fc999["name"]];
                            else
                                $Vf32353ea4a4bf46b014307995b4215 = urlencode($Vbbdbcdcf08d55a84fb2d3b511c7a9b[$V73d4fc339cd9a5a0e79143fd3fc999["name"]]);
                            $V4a8a08f09d37b73795649038408b5f["link"] = str_replace("{" . $V73d4fc339cd9a5a0e79143fd3fc999["name"] . "}", $Vf32353ea4a4bf46b014307995b4215, $V4a8a08f09d37b73795649038408b5f["link"]);
                        } $V815be97df65d6c4b510cd07189c534 = "";
                        if (!empty($V4a8a08f09d37b73795649038408b5f["linkoptions"]))
                            $V815be97df65d6c4b510cd07189c534 = $V4a8a08f09d37b73795649038408b5f["linkoptions"];
                        if (strpos($this->V82e89bfbf8b0b8c2424e5e654b00b8, "mssql") !== false)
                            $Vf1965a857bc285d26fe22023aa5ab5[$V6f6c99bba6081f21f3f0b75ee98cf5] = htmlentities(utf8_encode($Vf1965a857bc285d26fe22023aa5ab5[$V6f6c99bba6081f21f3f0b75ee98cf5]), ENT_QUOTES, "UTF-8");
                        else
                            $Vf1965a857bc285d26fe22023aa5ab5[$V6f6c99bba6081f21f3f0b75ee98cf5] = htmlentities($Vf1965a857bc285d26fe22023aa5ab5[$V6f6c99bba6081f21f3f0b75ee98cf5], ENT_QUOTES, "UTF-8");
                        if (isset($V4a8a08f09d37b73795649038408b5f["formatoptions"]["newformat"])) {
                            $Vf387e314fe3d7a3eadf79aa76b228d = $V4a8a08f09d37b73795649038408b5f["formatoptions"]["newformat"];
                            $Vf387e314fe3d7a3eadf79aa76b228d = str_replace("yy", "Y", $Vf387e314fe3d7a3eadf79aa76b228d);
                            $Vf387e314fe3d7a3eadf79aa76b228d = str_replace("mm", "m", $Vf387e314fe3d7a3eadf79aa76b228d);
                            $Vf387e314fe3d7a3eadf79aa76b228d = str_replace("dd", "d", $Vf387e314fe3d7a3eadf79aa76b228d);
                            $Vf1965a857bc285d26fe22023aa5ab5[$V6f6c99bba6081f21f3f0b75ee98cf5] = date($V4a8a08f09d37b73795649038408b5f["formatoptions"]["newformat"], strtotime($Vf1965a857bc285d26fe22023aa5ab5[$V6f6c99bba6081f21f3f0b75ee98cf5]));
                        } $Vf1965a857bc285d26fe22023aa5ab5[$V6f6c99bba6081f21f3f0b75ee98cf5] = "<a $V815be97df65d6c4b510cd07189c534 href='{$V4a8a08f09d37b73795649038408b5f["link"]}'>{$Vf1965a857bc285d26fe22023aa5ab5[$V6f6c99bba6081f21f3f0b75ee98cf5]}</a>";
                    } if (isset($V4a8a08f09d37b73795649038408b5f["formatter"]) && $V4a8a08f09d37b73795649038408b5f["formatter"] == "image") {
                        $V815be97df65d6c4b510cd07189c534 = array();
                        foreach ($V4a8a08f09d37b73795649038408b5f["formatoptions"] as $V8ce4b16b22b58894aa86c421e8759d => $V9e3669d19b675bd57058fd4664205d)
                            $V815be97df65d6c4b510cd07189c534[] = "$V8ce4b16b22b58894aa86c421e8759d='$V9e3669d19b675bd57058fd4664205d'";
                        $V815be97df65d6c4b510cd07189c534 = implode(" ", $V815be97df65d6c4b510cd07189c534);
                        $Vf1965a857bc285d26fe22023aa5ab5[$V6f6c99bba6081f21f3f0b75ee98cf5] = "<img $V815be97df65d6c4b510cd07189c534 src='" . $Vf1965a857bc285d26fe22023aa5ab5[$V6f6c99bba6081f21f3f0b75ee98cf5] . "'>";
                    } if (isset($V4a8a08f09d37b73795649038408b5f["formatter"]) && $V4a8a08f09d37b73795649038408b5f["formatter"] == "password")
                        $Vf1965a857bc285d26fe22023aa5ab5[$V6f6c99bba6081f21f3f0b75ee98cf5] = "*****";
                } foreach ($Vf1965a857bc285d26fe22023aa5ab5 as $V8ce4b16b22b58894aa86c421e8759d => $V4b43b0aee35624cd95b910189b3dc2)
                    $Vf1965a857bc285d26fe22023aa5ab5[$V8ce4b16b22b58894aa86c421e8759d] = stripslashes($Vf1965a857bc285d26fe22023aa5ab5[$V8ce4b16b22b58894aa86c421e8759d]);
                $Vfb5270b9d9076a4df05bfce5b30d43->rows[] = $Vf1965a857bc285d26fe22023aa5ab5;
            } if (!empty($V08fd04da1b9c3e4c1c9ab1fe42494a))
                $Vfb5270b9d9076a4df05bfce5b30d43->V08fd04da1b9c3e4c1c9ab1fe42494a = $V08fd04da1b9c3e4c1c9ab1fe42494a;
            if (strpos($this->V82e89bfbf8b0b8c2424e5e654b00b8, "mssql") !== false)
                $Vfb5270b9d9076a4df05bfce5b30d43 = Fbcdbd6e55bcebccb5e372537a6cf1d($Vfb5270b9d9076a4df05bfce5b30d43);
            echo json_encode($Vfb5270b9d9076a4df05bfce5b30d43);
            die;
        } if (is_array($this->table)) {
            $this->options["data"] = json_encode($this->table);
            $this->options["datatype"] = "local";
            $this->actions["rowactions"] = false;
            $this->actions["add"] = false;
            $this->actions["edit"] = false;
            $this->actions["delete"] = false;
        } $this->options["pager"] = '#' . $grid_id . "_pager";
        $this->options["jsonReader"] = array("repeatitems" => false, "id" => "0");
        if (($this->actions["edit"] === false && $this->actions["delete"] === false) || $this->options["cellEdit"] === true)
            $this->actions["rowactions"] = false;
        if ($this->actions["rowactions"] !== false) {
            $V8fa14cdd754f91cc6554c9e71929cc = false;
            $V7238ac6d63e05e296659e134dc240f = false;
            foreach ($this->options["colModel"] as &$V4a8a08f09d37b73795649038408b5f) {
                if ($V4a8a08f09d37b73795649038408b5f["name"] == "act") {
                    $V7238ac6d63e05e296659e134dc240f = &$V4a8a08f09d37b73795649038408b5f;
                } if (!empty($V4a8a08f09d37b73795649038408b5f["width"])) {
                    $V8fa14cdd754f91cc6554c9e71929cc = true;
                }
            } if ($this->Vd1efad72dc5b17dc66a46767c32fff["actionicon"] === true)
                $Vf1290186a5d0b1ceab27f4e77c0c5d = ($this->actions["clone"] === true) ? "80" : "55";
            else
                $Vf1290186a5d0b1ceab27f4e77c0c5d = ($this->actions["clone"] === true) ? "120" : "100";
            $V2d9ba4243a105608833c72694401c2 = array("name" => "act", "fixed" => true, "align" => "center", "index" => "act", "width" => "$Vf1290186a5d0b1ceab27f4e77c0c5d", "sortable" => false, "search" => false, "viewable" => false);
            if (!$V7238ac6d63e05e296659e134dc240f) {
                $this->options["colNames"][] = "Actions";
                $this->options["colModel"][] = $V2d9ba4243a105608833c72694401c2;
            } else
                $V7238ac6d63e05e296659e134dc240f = array_merge($V2d9ba4243a105608833c72694401c2, $V7238ac6d63e05e296659e134dc240f);
        } $Vfc62f298197cf2c21c9317fd4540c5 = '';
        $V61f8a820d2f250682f227e6ecbb76d = '';
        $Vc01067701106d44e0b2648215f15ec = '';
        $V70f605c62e22acd9cb5c2bc17e6c33 = '';
        $V42f26a3d181e92458f4b86052e6299 = '';
        foreach ($this->options["colModel"] as &$V4a8a08f09d37b73795649038408b5f) {
            if (!empty($V4a8a08f09d37b73795649038408b5f["link"])) {
                $this->options["reloadedit"] = true;
                $V4a8a08f09d37b73795649038408b5f["formatter"] = "function(cellvalue, options, rowObject){ arr = jQuery(document).data('link_{$V4a8a08f09d37b73795649038408b5f["name"]}');			if (!arr) arr = {}; if (jQuery(cellvalue).text() != '') { arr[jQuery(cellvalue).text()] = cellvalue;			jQuery(document).data('link_{$V4a8a08f09d37b73795649038408b5f["name"]}',arr); return arr[jQuery(cellvalue).text()];			} else { if (typeof(arr[cellvalue]) == 'undefined') return ''; else return arr[cellvalue]; } }";
                $V4a8a08f09d37b73795649038408b5f["unformat"] = "function(cellvalue, options, cell){return jQuery(cell).text();}";
            } if (isset($V4a8a08f09d37b73795649038408b5f["editrules"]["readonly"])) {
                if ($V4a8a08f09d37b73795649038408b5f["editrules"]["readonly"] === true) {
                    $Ve4d23e841d8e8804190027bce3180f = "input";
                    if (!empty($V4a8a08f09d37b73795649038408b5f["edittype"]))
                        $Ve4d23e841d8e8804190027bce3180f = $V4a8a08f09d37b73795649038408b5f["edittype"];
                    if (!empty($V4a8a08f09d37b73795649038408b5f["editrules"]["readonly-when"])) {
                        $V26542fb18a8b14c9775aa475f23c90 = $V4a8a08f09d37b73795649038408b5f["editrules"]["readonly-when"];
                        if (!is_numeric($V26542fb18a8b14c9775aa475f23c90[1]))
                            $V26542fb18a8b14c9775aa475f23c90[1] = '"' . $V26542fb18a8b14c9775aa475f23c90[1] . '"';
                        $V70f605c62e22acd9cb5c2bc17e6c33 .= 'if (jQuery("#tr_' . $V4a8a08f09d37b73795649038408b5f["index"] . ' .DataTD ' . $Ve4d23e841d8e8804190027bce3180f . '",formid).val() ' . $V26542fb18a8b14c9775aa475f23c90[0] . ' ' . $V26542fb18a8b14c9775aa475f23c90[1] . ')';
                        $V42f26a3d181e92458f4b86052e6299 .= 'if (jQuery("' . $Ve4d23e841d8e8804190027bce3180f . '[name=' . $V4a8a08f09d37b73795649038408b5f["index"] . ']:last").val() ' . $V26542fb18a8b14c9775aa475f23c90[0] . ' ' . $V26542fb18a8b14c9775aa475f23c90[1] . ')';
                    } $V70f605c62e22acd9cb5c2bc17e6c33 .= '{';
                    if ($Ve4d23e841d8e8804190027bce3180f == "select")
                        $V70f605c62e22acd9cb5c2bc17e6c33 .= 'jQuery("#tr_' . $V4a8a08f09d37b73795649038408b5f["index"] . ' .DataTD",formid).append("&nbsp;" + jQuery("#tr_' . $V4a8a08f09d37b73795649038408b5f["index"] . ' .DataTD ' . $Ve4d23e841d8e8804190027bce3180f . ' option:selected",formid).text());';
                    else
                        $V70f605c62e22acd9cb5c2bc17e6c33 .= 'jQuery("#tr_' . $V4a8a08f09d37b73795649038408b5f["index"] . ' .DataTD",formid).append("&nbsp;" + jQuery("#tr_' . $V4a8a08f09d37b73795649038408b5f["index"] . ' .DataTD ' . $Ve4d23e841d8e8804190027bce3180f . '",formid).val());';
                    $V70f605c62e22acd9cb5c2bc17e6c33 .= 'jQuery("#tr_' . $V4a8a08f09d37b73795649038408b5f["index"] . ' .DataTD ' . $Ve4d23e841d8e8804190027bce3180f . '",formid).hide();';
                    $V70f605c62e22acd9cb5c2bc17e6c33 .= 'jQuery("#tr_' . $V4a8a08f09d37b73795649038408b5f["index"] . ' .DataTD font",formid).hide();';
                    $V70f605c62e22acd9cb5c2bc17e6c33 .= '}';
                    $V42f26a3d181e92458f4b86052e6299 .= '{';
                    $V42f26a3d181e92458f4b86052e6299 .= 'jQuery("' . $Ve4d23e841d8e8804190027bce3180f . '[name=' . $V4a8a08f09d37b73795649038408b5f["index"] . ']:last").hide();';
                    $V42f26a3d181e92458f4b86052e6299 .= 'jQuery("' . $Ve4d23e841d8e8804190027bce3180f . '[name=' . $V4a8a08f09d37b73795649038408b5f["index"] . ']:last").parent().not(":has(span)").append("<span></span>");';
                    $V42f26a3d181e92458f4b86052e6299 .= 'jQuery("' . $Ve4d23e841d8e8804190027bce3180f . '[name=' . $V4a8a08f09d37b73795649038408b5f["index"] . ']:last").parent().children("span").html(jQuery("' . $Ve4d23e841d8e8804190027bce3180f . '[name=' . $V4a8a08f09d37b73795649038408b5f["index"] . ']:last").val());';
                    $V42f26a3d181e92458f4b86052e6299 .= '}';
                } unset($V4a8a08f09d37b73795649038408b5f["editrules"]["readonly"]);
            } if (!empty($V4a8a08f09d37b73795649038408b5f["show"])) {
                if ($V4a8a08f09d37b73795649038408b5f["show"]["list"] === false)
                    $V4a8a08f09d37b73795649038408b5f["hidden"] = true;
                else
                    $V4a8a08f09d37b73795649038408b5f["hidden"] = false;
                if ($V4a8a08f09d37b73795649038408b5f["formoptions"]["rowpos"]) {
                    $V12da44c23d64ea6cd8c0613d7a22fc = '';
                    $V12da44c23d64ea6cd8c0613d7a22fc .= 'jQuery("#TblGrid_' . $grid_id . ' tr:eq(' . ($V4a8a08f09d37b73795649038408b5f["formoptions"]["rowpos"] + 1) . ') td:nth-child(' . ($V4a8a08f09d37b73795649038408b5f["formoptions"]["colpos"] * 2) . ')").html("");';
                    $V12da44c23d64ea6cd8c0613d7a22fc .= 'jQuery("#TblGrid_' . $grid_id . ' tr:eq(' . ($V4a8a08f09d37b73795649038408b5f["formoptions"]["rowpos"] + 1) . ') td:nth-child(' . ($V4a8a08f09d37b73795649038408b5f["formoptions"]["colpos"] * 2 - 1) . ')").html("");';
                } if ($V4a8a08f09d37b73795649038408b5f["show"]["edit"] === false) {
                    $V70f605c62e22acd9cb5c2bc17e6c33 .= 'jQuery("#tr_' . $V4a8a08f09d37b73795649038408b5f["index"] . '",formid).hide();';
                    if (!empty($V12da44c23d64ea6cd8c0613d7a22fc))
                        $V70f605c62e22acd9cb5c2bc17e6c33 .= $V12da44c23d64ea6cd8c0613d7a22fc;
                } else
                    $V70f605c62e22acd9cb5c2bc17e6c33 .= 'jQuery("#tr_' . $V4a8a08f09d37b73795649038408b5f["index"] . '",formid).show();';
                if ($V4a8a08f09d37b73795649038408b5f["show"]["add"] === false) {
                    $V3df225470d0edb3623df96bae6418d .= 'jQuery("#tr_' . $V4a8a08f09d37b73795649038408b5f["index"] . '",formid).hide();';
                    if (!empty($V12da44c23d64ea6cd8c0613d7a22fc))
                        $V3df225470d0edb3623df96bae6418d .= $V12da44c23d64ea6cd8c0613d7a22fc;
                } else
                    $V3df225470d0edb3623df96bae6418d .= 'jQuery("#tr_' . $V4a8a08f09d37b73795649038408b5f["index"] . '",formid).show();';
                if ($V4a8a08f09d37b73795649038408b5f["show"]["view"] === false) {
                    $Ve095f8097a0316f8e827dc340cb14b .= 'jQuery("#trv_' . $V4a8a08f09d37b73795649038408b5f["index"] . '").hide();';
                    if ($V4a8a08f09d37b73795649038408b5f["formoptions"]["rowpos"]) {
                        $V12da44c23d64ea6cd8c0613d7a22fc = '';
                        $V12da44c23d64ea6cd8c0613d7a22fc .= 'jQuery("#ViewTbl_' . $grid_id . ' tr:eq(' . ($V4a8a08f09d37b73795649038408b5f["formoptions"]["rowpos"] - 1) . ') td:nth-child(' . ($V4a8a08f09d37b73795649038408b5f["formoptions"]["colpos"] * 2) . ')").html("");';
                        $V12da44c23d64ea6cd8c0613d7a22fc .= 'jQuery("#ViewTbl_' . $grid_id . ' tr:eq(' . ($V4a8a08f09d37b73795649038408b5f["formoptions"]["rowpos"] - 1) . ') td:nth-child(' . ($V4a8a08f09d37b73795649038408b5f["formoptions"]["colpos"] * 2 - 1) . ')").html("");';
                        $Ve095f8097a0316f8e827dc340cb14b .= $V12da44c23d64ea6cd8c0613d7a22fc;
                    }
                } else
                    $Ve095f8097a0316f8e827dc340cb14b .= 'jQuery("#trv_' . $V4a8a08f09d37b73795649038408b5f["index"] . '").show();';
                unset($V4a8a08f09d37b73795649038408b5f["show"]);
            }
        } if (!empty($this->Vd1efad72dc5b17dc66a46767c32fff["add_options"]["beforeShowForm"]))
            $Vfc62f298197cf2c21c9317fd4540c5 = $V3df225470d0edb3623df96bae6418d . $this->Vd1efad72dc5b17dc66a46767c32fff["add_options"]["beforeShowForm"];
        else
            $Vfc62f298197cf2c21c9317fd4540c5 = $V3df225470d0edb3623df96bae6418d;
        if (!empty($this->Vd1efad72dc5b17dc66a46767c32fff["edit_options"]["beforeShowForm"]))
            $V61f8a820d2f250682f227e6ecbb76d = $V70f605c62e22acd9cb5c2bc17e6c33 . $this->Vd1efad72dc5b17dc66a46767c32fff["edit_options"]["beforeShowForm"];
        else
            $V61f8a820d2f250682f227e6ecbb76d = $V70f605c62e22acd9cb5c2bc17e6c33;
        if (!empty($this->Vd1efad72dc5b17dc66a46767c32fff["delete_options"]["beforeShowForm"]))
            $Vc01067701106d44e0b2648215f15ec = $V9ab93b1e41276fbec3223183a11f87 . $this->Vd1efad72dc5b17dc66a46767c32fff["delete_options"]["beforeShowForm"];
        else
            $Vc01067701106d44e0b2648215f15ec = $V9ab93b1e41276fbec3223183a11f87;
        if (!empty($this->Vd1efad72dc5b17dc66a46767c32fff["view_options"]["beforeShowForm"]))
            $Veb4a7e2bbf9c2919b11dde9cbdf88b = $Ve095f8097a0316f8e827dc340cb14b . $this->Vd1efad72dc5b17dc66a46767c32fff["view_options"]["beforeShowForm"];
        else
            $Veb4a7e2bbf9c2919b11dde9cbdf88b = $Ve095f8097a0316f8e827dc340cb14b;
        $this->options["add_options"]["beforeShowForm"] = 'function(formid) { ' . $Vfc62f298197cf2c21c9317fd4540c5 . ' }';
        $this->options["edit_options"]["beforeShowForm"] = 'function(formid) { ' . $V61f8a820d2f250682f227e6ecbb76d . ' }';
        $this->options["delete_options"]["beforeShowForm"] = 'function(formid) { ' . $Vc01067701106d44e0b2648215f15ec . ' }';
        $Vc3f9558d681bac963339b7c69894c4 = "";
        if (!empty($this->options["view_options"]["beforeShowForm"]))
            $Vc3f9558d681bac963339b7c69894c4 = "var o=" . $this->options["view_options"]["beforeShowForm"] . "; o(formid);";
        $this->options["view_options"]["beforeShowForm"] = 'function(formid) { ' . $Veb4a7e2bbf9c2919b11dde9cbdf88b . $Vc3f9558d681bac963339b7c69894c4 . ' }';
        $this->options["add_options"]["afterComplete"] = "function (response, postdata) { r = JSON.parse(response.responseText); $('#{$grid_id}').setSelection(r.id); }";
        $this->options["view_options"]["afterclickPgButtons"] = 'function(formid) { ' . $Ve095f8097a0316f8e827dc340cb14b . ' }';
        $V3c544d02181645f20f280fb3af8218 = "";
        if (!empty($this->options["onAfterSave"]))
            $V3c544d02181645f20f280fb3af8218 .= "var fx_save = {$this->options["onAfterSave"]}; fx_save();";
        if ($this->options["reloadedit"] === true)
            $V3c544d02181645f20f280fb3af8218 .= "jQuery('#$grid_id').jqGrid().trigger('reloadGrid',[{jqgrid_page:1}]);";
        if (empty($this->options["add_options"]["success_msg"]))
            $this->options["add_options"]["success_msg"] = "Record added";
        if (empty($this->options["edit_options"]["success_msg"]))
            $this->options["edit_options"]["success_msg"] = "Record updated";
        if (empty($this->options["edit_options"]["success_msg_bulk"]))
            $this->options["edit_options"]["success_msg_bulk"] = "Record(s) updated";
        if (empty($this->options["delete_options"]["success_msg"]))
            $this->options["delete_options"]["success_msg"] = "Record deleted";
        if (empty($this->options["add_options"]["afterSubmit"]))
            $this->options["add_options"]["afterSubmit"] = 'function(response) { if(response.status == 200)			 { fx_success_msg("' . $this->options["add_options"]["success_msg"] . '",1); return [true,""]; } }';
        if (empty($this->options["edit_options"]["afterSubmit"]))
            $this->options["edit_options"]["afterSubmit"] = 'function(response) { if(response.status == 200)			 { ' . $V3c544d02181645f20f280fb3af8218 . ' fx_success_msg("' . $this->options["edit_options"]["success_msg"] . '",1);			return [true,""]; } }';
        if (empty($this->options["delete_options"]["afterSubmit"]))
            $this->options["delete_options"]["afterSubmit"] = 'function(response) { if(response.status == 200)			 { fx_success_msg("' . $this->options["delete_options"]["success_msg"] . '",1); return [true,""]; } }';
        $this->options["search_options"]["multipleSearch"] = ($this->actions["search"] == "advance") ? true : false;
        $this->options["search_options"]["sopt"] = array('eq', 'ne', 'lt', 'le', 'gt', 'ge', 'bw', 'bn', 'in', 'ni', 'ew', 'en', 'cn', 'nc', 'nu', 'nn');
        $Vc68271a63ddbc431c307beb7d29182 = json_encode_jsfunc($this->options);
        $Vc68271a63ddbc431c307beb7d29182 = substr($Vc68271a63ddbc431c307beb7d29182, 0, strlen($Vc68271a63ddbc431c307beb7d29182) - 1);
        if ($this->actions["rowactions"] !== false) {
            $Vbdbd5632ce745fb23276e53b9b5c6e = array();
            {
                if ($this->actions["edit"] !== false)
                    $Vbdbd5632ce745fb23276e53b9b5c6e[] = "<a title=\"Edit this row\" href=\"javascript:void(0);\" onclick=\"jQuery(this).dblclick();\">Edit</a>";
                if ($this->actions["delete"] !== false)
                    $Vbdbd5632ce745fb23276e53b9b5c6e[] = "<a title=\"Delete this row\" href=\"javascript:void(0);\" onclick=\"jQuery(\'#$grid_id\').delGridRow(\''+cl+'\',{errorTextFormat:function(r){ return r.responseText;}}); jQuery(\'#delmod$grid_id\').abscenter(); \">Delete</a>";
                $Vbdbd5632ce745fb23276e53b9b5c6e = implode(" | ", $Vbdbd5632ce745fb23276e53b9b5c6e);
                $Vc68271a63ddbc431c307beb7d29182 .= ",'gridComplete': function()			 { var ids = jQuery('#$grid_id').jqGrid('getDataIDs'); for(var i=0;i < ids.length;i++) { var cl = ids[i];			 be = '$Vbdbd5632ce745fb23276e53b9b5c6e'; se = ' <a title=\"Save this row\" href=\"javascript:void(0);\" onclick=\"jQuery(\'#{$grid_id}_ilsave\').click(); if (jQuery(\'#$grid_id\').saveRow(\''+cl+'\') || jQuery(\'.editable\').length==0) { jQuery(this).parent().hide(); jQuery(this).parent().prev().show(); " . addslashes($V3c544d02181645f20f280fb3af8218) . " }\">Save</a>'; 			 ce = ' | <a title=\"Restore this row\" href=\"javascript:void(0);\" onclick=\"jQuery(\'#{$grid_id}_ilcancel\').click(); jQuery(\'#$grid_id\').restoreRow(\''+cl+'\'); jQuery(this).parent().hide(); jQuery(this).parent().prev().show();\">Cancel</a>'; 			 if (ids[i].indexOf('jqg') != -1) { se = ' <a title=\"Save this row\" href=\"javascript:void(0);\" onclick=\"jQuery(\'#{$grid_id}_ilsave\').click(); \">Save</a>'; 			 ce = ' | <a title=\"Restore this row\" href=\"javascript:void(0);\" onclick=\"jQuery(\'#{$grid_id}_ilcancel\').click(); jQuery(this).parent().hide(); jQuery(this).parent().prev().show();\">Cancel</a>'; 			 jQuery('#$grid_id').jqGrid('setRowData',ids[i],{act:'<span style=display:none id=\"edit_row_{$grid_id}_'+cl+'\">'+be+'</span>'+'<span id=\"save_row_{$grid_id}_'+cl+'\">'+se+ce+'</span>'});			} else jQuery('#$grid_id').jqGrid('setRowData',ids[i],{act:'<span id=\"edit_row_{$grid_id}_'+cl+'\">'+be+'</span>'+'<span style=display:none id=\"save_row_{$grid_id}_'+cl+'\">'+se+ce+'</span>'});			} }";
            }
        } if ($this->actions["rowactions"] !== false && $this->actions["edit"] !== false && $this->options["cellEdit"] !== true) {
            $Vc68271a63ddbc431c307beb7d29182 .= ",'ondblClickRow': function (id, iRow, iCol, e) { if (!e) e = window.event;			var element = e.target || e.srcElement; if(id && id!==lastSel) { if (typeof(lastSel) != 'undefined' && jQuery('.editable').length >0 && !confirm('Changes are not saved, Reset changes?'))			 return; jQuery('#$grid_id').restoreRow(lastSel); jQuery('#edit_row_{$grid_id}_'+lastSel).show();			jQuery('#save_row_{$grid_id}_'+lastSel).hide(); lastSel=id; } jQuery('#$grid_id').editRow(id, true, function()			 { setTimeout(function(){ jQuery('input, select, textarea', element).focus(); },100); }, function()			 { jQuery('#edit_row_{$grid_id}_'+id).show(); jQuery('#save_row_{$grid_id}_'+id).hide(); return true;			},null,null, function() { $V3c544d02181645f20f280fb3af8218 },null, function() { jQuery('#edit_row_{$grid_id}_'+id).show();			jQuery('#save_row_{$grid_id}_'+id).hide(); return true; } ); if (jQuery('#{$grid_id}_iledit').length)			 { jQuery('#{$grid_id}').setSelection(id, true); jQuery('#{$grid_id}_iledit').click(); } jQuery('#edit_row_{$grid_id}_'+id).hide();			jQuery('#save_row_{$grid_id}_'+id).show(); $V42f26a3d181e92458f4b86052e6299 }";
        } $Vc68271a63ddbc431c307beb7d29182 .= ",'loadError': function(xhr,status, err) { 			 try { jQuery.jgrid.info_dialog(jQuery.jgrid.errors.errcap,'<div class=\"ui-state-error\">'+ xhr.responseText +'</div>', 			 jQuery.jgrid.edit.bClose,{buttonalign:'right'}); } catch(e) { alert(xhr.responseText);} } ";
        $Vc68271a63ddbc431c307beb7d29182 .= ",'onSelectRow': function(ids) { ";
        $Vc68271a63ddbc431c307beb7d29182 .= "}";
        if ($this->options["scroll"] == true) {
            $Vc68271a63ddbc431c307beb7d29182 .= ",'beforeRequest': function() {";
            $Vc68271a63ddbc431c307beb7d29182 .= "jQuery('#$grid_id').data('jqgrid_rows',jQuery('#$grid_id tr.jqgrow').length);";
            $Vc68271a63ddbc431c307beb7d29182 .= "}";
        } $Vc68271a63ddbc431c307beb7d29182 .= ",'loadComplete': function(ids) {";
        $Vc68271a63ddbc431c307beb7d29182 .= "jQuery('#{$grid_id}_pager option[value=\"All\"]').val(99999);";
        $Vc68271a63ddbc431c307beb7d29182 .= "if (jQuery('#{$grid_id}').getGridParam('records') == 0) { if (jQuery('#div_no_record_{$grid_id}').length==0) 			 jQuery('#gbox_{$grid_id} .ui-jqgrid-bdiv').not('.frozen-bdiv').append('<div id=\"div_no_record_{$grid_id}\" align=\"center\" style=\"padding:30px 0;\">'+jQuery.jgrid.defaults.emptyrecords+'</div>'); 			 else jQuery('#div_no_record_{$grid_id}').show(); } else { jQuery('#div_no_record_{$grid_id}').hide();			}";
        $V12c07319574bc90212ab0b5c23bd49 = "";
        if ($this->options["scroll"] == true) {
            $V12c07319574bc90212ab0b5c23bd49 = " var last_rows = 0;			if (typeof(jQuery('#$grid_id').data('jqgrid_rows')) != 'undefined') i = i + jQuery('#$grid_id').data('jqgrid_rows');			";
        } $Vc68271a63ddbc431c307beb7d29182 .= "if(ids && ids.rows) jQuery.each(ids.rows,function(i){ $V12c07319574bc90212ab0b5c23bd49			 ";
        $Vc68271a63ddbc431c307beb7d29182 .= "});";
        if (!empty($this->events["js_on_load_complete"])) {
            $Vc68271a63ddbc431c307beb7d29182 .= "if (typeof({$this->events["js_on_load_complete"]}) != 'undefined') {$this->events["js_on_load_complete"]}(ids);";
        } $Vc68271a63ddbc431c307beb7d29182 .= "}";
        $Vc68271a63ddbc431c307beb7d29182 .= "}";
        if (!isset($this->V86c223b5ea2c7e35154ae4410cd891["param"])) {
            $this->V86c223b5ea2c7e35154ae4410cd891["param"]["edit"] = ($this->actions["edit"] === false) ? false : true;
            $this->V86c223b5ea2c7e35154ae4410cd891["param"]["add"] = ($this->actions["add"] === false) ? false : true;
            $this->V86c223b5ea2c7e35154ae4410cd891["param"]["del"] = ($this->actions["delete"] === false) ? false : true;
            $this->V86c223b5ea2c7e35154ae4410cd891["param"]["view"] = ($this->actions["view"] === true) ? true : false;
            $this->V86c223b5ea2c7e35154ae4410cd891["param"]["refresh"] = ($this->actions["refresh"] === false) ? false : true;
            $this->V86c223b5ea2c7e35154ae4410cd891["param"]["search"] = ($this->actions["search"] === false) ? false : true;
            if (!empty($this->V86c223b5ea2c7e35154ae4410cd891["param"]["delete"]))
                $this->V86c223b5ea2c7e35154ae4410cd891["param"]["del"] = $this->V86c223b5ea2c7e35154ae4410cd891["param"]["delete"];
        } ob_start();
        ?> <table id="<?php echo $grid_id ?>"></table> <div id="<?php echo $grid_id . "_pager" ?>"></div> 			 <script> var phpgrid = jQuery("#<?php echo $grid_id ?>");
            var phpgrid_pager = jQuery("#<?php echo $grid_id . "_pager" ?>");
            var fx_ajax_file_upload;
            var fx_replace_upload;
            var fx_bulk_update;
            var fx_get_dropdown;
            jQuery(document).ready(function () {
        <?php echo $this->F300015ed2190df99db5f1bad555700($grid_id, $Vc68271a63ddbc431c307beb7d29182); ?>
        });</script> <?php return ob_get_clean();
    }

    function F300015ed2190df99db5f1bad555700($grid_id, $Vc68271a63ddbc431c307beb7d29182) { ?> var lastSel; fx_clone_row = function (grid,id) { myData = {}; myData.id = id; myData.grid_id = grid;			myData.oper = 'clone'; jQuery.ajax({ url: "<?php echo $this->options["url"] ?>", dataType: "json",			 data: myData, type: "POST", error: function(res, status) { alert(res.status+" : "+res.statusText+". Status: "+status);			}, success: function( data ) { } }); jQuery("#"+grid).jqGrid().trigger('reloadGrid',[{jqgrid_page:1}]);			}; var extra_opts = {}; <?php ?> if (typeof(opts) != 'undefined') extra_opts = opts; if (typeof(opts_<?php echo $grid_id ?>) != 'undefined') extra_opts = opts_<?php echo $grid_id ?>;			var grid_<?php echo $grid_id ?> = jQuery("#<?php echo $grid_id ?>").jqGrid( jQuery.extend(<?php echo $Vc68271a63ddbc431c307beb7d29182 ?>, extra_opts ) );			 jQuery("#<?php echo $grid_id ?>").jqGrid('navGrid','#<?php echo $grid_id . "_pager" ?>', <?php echo json_encode_jsfunc($this->V86c223b5ea2c7e35154ae4410cd891["param"]) ?>,			 <?php echo json_encode_jsfunc($this->options["edit_options"]) ?>, <?php echo json_encode_jsfunc($this->options["add_options"]) ?>,			 <?php echo json_encode_jsfunc($this->options["delete_options"]) ?>, <?php echo json_encode_jsfunc($this->options["search_options"]) ?>,			 <?php echo json_encode_jsfunc($this->options["view_options"]) ?> ); <?php ?> <?php if ($this->actions["inlineadd"] !== false || $this->actions["inline"] === true) { ?>			 jQuery('#<?php echo $grid_id ?>').jqGrid('inlineNav','#<?php echo $grid_id . "_pager" ?>',{"add":true,"edit":true,"save":true,"cancel":true,			 "addParams":{ "addRowParams": { "oneditfunc": function(id) { jQuery("#edit_row_<?php echo $grid_id ?>_"+id+" a:first").click(); 			 }, "afterrestorefunc": function(id) { jQuery("#save_row_<?php echo $grid_id ?>_"+id+" a:last").parent().hide().prev().show(); 			 }, "aftersavefunc":function (id, res) { jQuery('#<?php echo $grid_id ?>').trigger("reloadGrid",[{jqgrid_page:1}]);			}, "errorfunc": function(id,res) { jQuery.jgrid.info_dialog(jQuery.jgrid.errors.errcap,'<div class=\"ui-state-error\">'+ res.responseText +'</div>', 			 jQuery.jgrid.edit.bClose,{buttonalign:'right'}); jQuery('#<?php echo $grid_id ?>').trigger("reloadGrid",[{jqgrid_page:1}]);			} } } ,"editParams":{ "aftersavefunc":function (id, res) { jQuery('#<?php echo $grid_id ?>').trigger("reloadGrid",[{jqgrid_page:1}]);			}, "errorfunc": function(id,res) { jQuery.jgrid.info_dialog(jQuery.jgrid.errors.errcap,'<div class=\"ui-state-error\">'+ res.responseText +'</div>', 			 jQuery.jgrid.edit.bClose,{buttonalign:'right'}); jQuery('#<?php echo $grid_id ?>').trigger("reloadGrid",[{jqgrid_page:1}]);			}, "oneditfunc": function(id) { jQuery('#<?php echo $grid_id ?>').jqGrid('setSelection',id); jQuery("#edit_row_<?php echo $grid_id ?>_"+id+" a:first").click(); 			 }, "afterrestorefunc": function(id) { jQuery("#save_row_<?php echo $grid_id ?>_"+id+" a:last").parent().hide().prev().show(); 			 } }}); <?php } ?> <?php if ($this->actions["autofilter"] !== false) { ?> jQuery("#<?php echo $grid_id ?>").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false, defaultSearch:'cn'}); 			 <?php } ?> <?php if ($this->actions["showhidecolumns"] !== false) { ?> jQuery("#<?php echo $grid_id ?>").jqGrid('navButtonAdd',"#<?php echo $grid_id . "_pager" ?>",{caption:"Columns",title:"Hide/Show Columns", buttonicon :'ui-icon-note',			 onClickButton:function(){ jQuery("#<?php echo $grid_id ?>").jqGrid('columnChooser',{width : 250, height:150, modal:true, done:function(){ c = jQuery('#colchooser_<?php echo $grid_id ?> select').val(); var colModel = jQuery("#<?php echo $grid_id ?>").jqGrid("getGridParam", "colModel"); str = ''; jQuery(c).each(function(i){ str += colModel[c[i]]['name'] + ","; }); document.cookie = 'jqgrid_colchooser=' + str; }, "dialog_opts" : {"minWidth": 270} });			jQuery("#colchooser_<?php echo $grid_id ?>").parent().position({ my: "center", at: "center", of: $("#gbox_<?php echo $grid_id ?>")			 }); } }); <?php } ?> <?php ?> <?php if ($this->actions["bulkedit"] === true) { ?> jQuery("#<?php echo $grid_id ?>").jqGrid('navButtonAdd',"#<?php echo $grid_id . "_pager" ?>",{			 'caption' : 'Bulk Edit', 'buttonicon' : 'ui-icon-pencil', 'onClickButton': function() { var ids = jQuery('#<?php echo $grid_id ?>').jqGrid('getGridParam','selarrrow'); 			 if (ids.length == 0) { jQuery.jgrid.info_dialog(jQuery.jgrid.errors.errcap,'<div class=\"ui-state-error\">'+jQuery.jgrid.nav.alerttext+'</div>', 			 jQuery.jgrid.edit.bClose,{buttonalign:'right'}); return; } jQuery('#<?php echo $grid_id ?>').jqGrid('editGridRow', ids, <?php echo json_encode_jsfunc($this->options["edit_options"]) ?>);			jQuery('#edithd<?php echo $grid_id ?> .ui-jqdialog-title').html("Bulk Edit"); jQuery('#editmod<?php echo $grid_id ?> .binfo').show();			jQuery('#editmod<?php echo $grid_id ?> .bottominfo').html("NOTE: Blank fields will be skipped"); jQuery('#editmod<?php echo $grid_id ?> select').prepend("<option value=''></option>").val('');			return true; }, 'position': 'last' }); <?php } ?> <?php ?> <?php if (isset($this->actions["clone"]) && $this->actions["clone"] === true) { ?> 			 jQuery("#<?php echo $grid_id ?>").jqGrid('navButtonAdd',"#<?php echo $grid_id . "_pager" ?>",{caption:"",title:"Clone", buttonicon :'ui-icon-copy',			 onClickButton:function(){ var selr = jQuery("#<?php echo $grid_id ?>").jqGrid('getGridParam','selrow');			if (!selr) { var alertIDs = {themodal:'alertmod',modalhead:'alerthd',modalcontent:'alertcnt'}; if (jQuery("#"+alertIDs.themodal).html() === null) {			 jQuery.jgrid.createModal(alertIDs,"<div>"+jQuery.jgrid.nav.alerttext+ "</div><span tabindex='0'><span tabindex='-1' id='jqg_alrt'></span></span>",			 {gbox:"#gbox_"+jQuery.jgrid.jqID(this.p.id),jqModal:true,drag:true,resize:true, caption:jQuery.jgrid.nav.alertcap,			 top:100,left:100,width:200,height: 'auto',closeOnEscape:true, zIndex: null},"","",true); } jQuery.jgrid.viewModal("#"+alertIDs.themodal,			 {gbox:"#gbox_"+jQuery.jgrid.jqID(this.p.id),jqm:true}); jQuery("#jqg_alrt").focus(); return; } fx_clone_row("<?php echo $grid_id ?>",selr);			} }); <?php } ?> <?php if ($this->actions["export"] === true || $this->actions["export_excel"] === true || $this->actions["export_pdf"] === true || $this->actions["export_csv"] === true) {
            $Vda3ad3b4322b19b609e4fa9d0a98a9 = "&sidx=" . $this->options["sortname"] . "&sord=" . $this->options["sortorder"] . "&rows=" . $this->options["rowNum"]; ?> function F3113f6c798c1640f3ce1f0ffc75e93(type) { type = type || ""; var detail_grid_params = jQuery("#<?php echo $grid_id ?>").data('jqgrid_detail_grid_params');			detail_grid_params = detail_grid_params || ""; if ("<?php echo $this->options["url"] ?>".indexOf("?") != -1)			 window.open("<?php echo $this->options["url"] ?>" + "&export=1&jqgrid_page=1&export_type="+type+"<?php echo $Vda3ad3b4322b19b609e4fa9d0a98a9 ?>"+detail_grid_params);			else window.open("<?php echo $this->options["url"] ?>" + "?export=1&jqgrid_page=1&export_type="+type+"<?php echo $Vda3ad3b4322b19b609e4fa9d0a98a9 ?>"+detail_grid_params);			} <?php } ?> <?php ?> fx_success_msg = function (msg,fade) { var t = Math.max(0, ((jQuery(window).height() - jQuery('#info_dialog').outerHeight()) / 2) + jQuery(window).scrollTop());			var l = Math.max(0, ((jQuery(window).width() - jQuery('#info_dialog').outerWidth()) / 2) + jQuery(window).scrollLeft());			jQuery.jgrid.info_dialog("Info","<div class='ui-state-highlight' style='padding:5px;'>"+msg+"</div>", 			 jQuery.jgrid.edit.bClose,{buttonalign:"right", left:l, top:t }); jQuery("#info_dialog").abscenter();			if (fade == 1) jQuery("#info_dialog").delay(1000).fadeOut(); }; <?php ?> <?php if (isset($this->options["toolbar"]) && $this->options["toolbar"] != "bottom") { ?> 			 jQuery(document).ready(function(){ <?php if ($this->options["toolbar"] == "top") { ?> jQuery('#<?php echo $grid_id ?>_pager').insertBefore('#<?php echo $grid_id ?>_toppager');			<?php } else if ($this->options["toolbar"] == "both") { ?> jQuery('#<?php echo $grid_id ?>_pager').clone(true).insertBefore('#<?php echo $grid_id ?>_toppager').attr('id','_toppager');			<?php } ?> jQuery('#<?php echo $grid_id ?>_pager').removeClass("ui-jqgrid-pager"); jQuery('#<?php echo $grid_id ?>_pager').addClass("ui-jqgrid-toppager");			jQuery('#<?php echo $grid_id ?>_toppager').remove(); jQuery('#_toppager').attr('id','<?php echo $grid_id ?>_toppager'); 			 if (jQuery("link[href$='ui.bootstrap.jqgrid.css']").length) { jQuery('div.frozen-div').css('top','+=6px');			jQuery('div.frozen-bdiv').css('top','+=6px'); } }); <?php } ?> <?php if ($this->options["autoresize"] === true) { ?>			 jQuery(window).bind("resize", function () { var oldWidth = jQuery("#<?php echo $grid_id ?>").jqGrid("getGridParam", "width"),			 newWidth = jQuery(window).width() - 30; if (oldWidth !== newWidth) { jQuery("#<?php echo $grid_id ?>").jqGrid("setGridWidth", newWidth);			} }).trigger("resize"); <?php } ?> <?php if ($this->options["resizable"] === true) { ?> jQuery("#<?php echo $grid_id ?>").jqGrid('gridResize',{});			<?php } ?> <?php ?> jQuery("#<?php echo $grid_id ?>").jqGrid('setFrozenColumns'); jQuery("#<?php echo $grid_id ?>").triggerHandler("jqGridAfterGridComplete"); 			 jQuery.fn.abscenter = function () { this.css("position","absolute"); this.css("top", Math.max(0, ((jQuery(window).height() - jQuery(this).outerHeight()) / 2) + 			 jQuery(window).scrollTop()) + "px"); this.css("left", Math.max(0, ((jQuery(window).width() - jQuery(this).outerWidth()) / 2) + 			 jQuery(window).scrollLeft()) + "px"); return this; }; jQuery.fn.fixedcenter = function () { this.css("position","fixed");			this.css("top", Math.max(0, ((jQuery(window).height() - jQuery(this).outerHeight()) / 2)) + "px"); this.css("left", Math.max(0, ((jQuery(window).width() - jQuery(this).outerWidth()) / 2)) + "px");			return this; }; <?php
    }

    function Fe9b3c79462166409c20167747931ab($Vac5c74b64b4b8352ef2f181affb5ac, $Vd77d5e503ad1439f585ac494268b35) {
        if (strpos($Vd77d5e503ad1439f585ac494268b35, "mssql") !== false) {
            $Vac5c74b64b4b8352ef2f181affb5ac = preg_replace("/SELECT (.*) LIMIT ([0-9]+) OFFSET ([0-9]+)/i", "select top ($2 + $3) $1", $Vac5c74b64b4b8352ef2f181affb5ac);
        } else if (strpos($Vd77d5e503ad1439f585ac494268b35, "oci8") !== false || strpos($Vd77d5e503ad1439f585ac494268b35, "db2") !== false) {
            preg_match("/(.*) LIMIT ([0-9]+) OFFSET ([0-9]+)/i", $Vac5c74b64b4b8352ef2f181affb5ac, $V9c28d32df234037773be184dbdafc2);
            if (count($V9c28d32df234037773be184dbdafc2)) {
                $V1b1cc7f086b3f074da452bc3129981 = $V9c28d32df234037773be184dbdafc2[1];
                $Vaa9f73eea60a006820d0f8768bc8a3 = $V9c28d32df234037773be184dbdafc2[2];
                $V70be495d9702540befac439bed536f = $V9c28d32df234037773be184dbdafc2[3];
                $Va5ae62869c0a18568c329176f5460a = $V70be495d9702540befac439bed536f;
                $V56389958306b1878a4ef0c4ec340f4 = $V70be495d9702540befac439bed536f + $Vaa9f73eea60a006820d0f8768bc8a3;
                $Vac5c74b64b4b8352ef2f181affb5ac = " SELECT * FROM ( SELECT a.*,rownum rnum FROM ($V1b1cc7f086b3f074da452bc3129981) a			 ) WHERE rnum > $Va5ae62869c0a18568c329176f5460a AND rnum <= $V56389958306b1878a4ef0c4ec340f4 ";
            }
        } return $Vac5c74b64b4b8352ef2f181affb5ac;
    }

    function F69129ad793d9569df115b389acab44($Vf1965a857bc285d26fe22023aa5ab5, $V341be97d9aff90c9978347f66f945b) {
        foreach ($this->options["colModel"] as $V73d4fc339cd9a5a0e79143fd3fc999) {
            $Vf32353ea4a4bf46b014307995b4215 = $Vf1965a857bc285d26fe22023aa5ab5[$V73d4fc339cd9a5a0e79143fd3fc999["name"]];
            $V341be97d9aff90c9978347f66f945b = str_replace("{" . $V73d4fc339cd9a5a0e79143fd3fc999["name"] . "}", $Vf32353ea4a4bf46b014307995b4215, $V341be97d9aff90c9978347f66f945b);
        } return $V341be97d9aff90c9978347f66f945b;
    }

    function Fd280460c57fe7dec4bf2ebe324999f($V341be97d9aff90c9978347f66f945b) {
        if (is_array($V341be97d9aff90c9978347f66f945b)) {
            foreach ($V341be97d9aff90c9978347f66f945b AS $Vb80bb7740288fda1f201890375a60c => $V2063c1608d6e0baf80249c42e2be58) {
                $V341be97d9aff90c9978347f66f945b[$Vb80bb7740288fda1f201890375a60c] = Fd280460c57fe7dec4bf2ebe324999f($V2063c1608d6e0baf80249c42e2be58);
            }
        } else {
            $V341be97d9aff90c9978347f66f945b = str_replace("'", "''", $V341be97d9aff90c9978347f66f945b);
        } return $V341be97d9aff90c9978347f66f945b;
    }

}

if (!function_exists('json_encode')) {
    require_once 'JSON.php';

    function json_encode($V61dd86c2dc75c3f569ec619bd283a3) {
        global $Vb3e1e61750d712b03c001c5fe79105;
        if (!isset($Vb3e1e61750d712b03c001c5fe79105)) {
            $Vb3e1e61750d712b03c001c5fe79105 = new Services_JSON();
        } return $Vb3e1e61750d712b03c001c5fe79105->encode($V61dd86c2dc75c3f569ec619bd283a3);
    }

    function json_decode($V61dd86c2dc75c3f569ec619bd283a3) {
        global $Vb3e1e61750d712b03c001c5fe79105;
        if (!isset($Vb3e1e61750d712b03c001c5fe79105)) {
            $Vb3e1e61750d712b03c001c5fe79105 = new Services_JSON();
        } return $Vb3e1e61750d712b03c001c5fe79105->decode($V61dd86c2dc75c3f569ec619bd283a3);
    }

} if (!function_exists('phpgrid_error')) {

    function phpgrid_error($V6e2baaf3b97dbeef01c0043275f9a0) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error');
        die($V6e2baaf3b97dbeef01c0043275f9a0);
    }

} if (!function_exists('phpgrid_pr')) {

    function phpgrid_pr($V47c80780ab608cc046f2a6e6f071fe, $Vf24f62eeb789199b9b2e467df3b187 = 0) {
        echo "<pre>";
        print_r($V47c80780ab608cc046f2a6e6f071fe);
        echo "</pre>";
        if ($Vf24f62eeb789199b9b2e467df3b187)
            die;
    }

}

function json_encode_jsfunc($Va43c1b0aa53a0c908810c06ab1ff39 = array(), $V4b5bea44af9baf871f58e4ecb54526 = array(), $Vc9e9a848920877e76685b2e4e76de3 = 0) {
    foreach ($Va43c1b0aa53a0c908810c06ab1ff39 as $V3c6e0b8a9c15224a8228b9a98ca153 => $V2063c1608d6e0baf80249c42e2be58) {
        if (is_array($V2063c1608d6e0baf80249c42e2be58)) {
            $V2cb9df9898e55fd0ad829dc202ddbd = json_encode_jsfunc($V2063c1608d6e0baf80249c42e2be58, $V4b5bea44af9baf871f58e4ecb54526, 1);
            $Va43c1b0aa53a0c908810c06ab1ff39[$V3c6e0b8a9c15224a8228b9a98ca153] = $V2cb9df9898e55fd0ad829dc202ddbd[0];
            $V4b5bea44af9baf871f58e4ecb54526 = $V2cb9df9898e55fd0ad829dc202ddbd[1];
        } else {
            if (substr($V2063c1608d6e0baf80249c42e2be58, 0, 8) == 'function') {
                $V19b0bee6b072408fc38b5d76725b76 = "#" . rand() . "#";
                $V4b5bea44af9baf871f58e4ecb54526[$V19b0bee6b072408fc38b5d76725b76] = $V2063c1608d6e0baf80249c42e2be58;
                $Va43c1b0aa53a0c908810c06ab1ff39[$V3c6e0b8a9c15224a8228b9a98ca153] = $V19b0bee6b072408fc38b5d76725b76;
            } else if (substr($V2063c1608d6e0baf80249c42e2be58, 0, 2) == '[{') {
                $V19b0bee6b072408fc38b5d76725b76 = "#" . rand() . "#";
                $V4b5bea44af9baf871f58e4ecb54526[$V19b0bee6b072408fc38b5d76725b76] = $V2063c1608d6e0baf80249c42e2be58;
                $Va43c1b0aa53a0c908810c06ab1ff39[$V3c6e0b8a9c15224a8228b9a98ca153] = $V19b0bee6b072408fc38b5d76725b76;
            }
        }
    } if ($Vc9e9a848920877e76685b2e4e76de3 == 1) {
        return array($Va43c1b0aa53a0c908810c06ab1ff39, $V4b5bea44af9baf871f58e4ecb54526);
    } else {
        $V7648c463fc599b54a77f6d6dcbd693 = json_encode($Va43c1b0aa53a0c908810c06ab1ff39);
        foreach ($V4b5bea44af9baf871f58e4ecb54526 as $V3c6e0b8a9c15224a8228b9a98ca153 => $V2063c1608d6e0baf80249c42e2be58) {
            $V7648c463fc599b54a77f6d6dcbd693 = str_replace('"' . $V3c6e0b8a9c15224a8228b9a98ca153 . '"', $V2063c1608d6e0baf80249c42e2be58, $V7648c463fc599b54a77f6d6dcbd693);
        } return $V7648c463fc599b54a77f6d6dcbd693;
    }
}

function Fbcdbd6e55bcebccb5e372537a6cf1d($Ve34d514f7db5c8aac72a7c8191a096) {
    if (is_string($Ve34d514f7db5c8aac72a7c8191a096)) {
        return utf8_encode($Ve34d514f7db5c8aac72a7c8191a096);
    } if (is_object($Ve34d514f7db5c8aac72a7c8191a096)) {
        $V99415f0b9a2ae6d7290f1add23e3e4 = get_object_vars($Ve34d514f7db5c8aac72a7c8191a096);
        $V22af645d1859cb5ca6da0c484f1f37 = $Ve34d514f7db5c8aac72a7c8191a096;
        foreach ($V99415f0b9a2ae6d7290f1add23e3e4 as $V8ce4b16b22b58894aa86c421e8759d => $V9e3669d19b675bd57058fd4664205d) {
            $V22af645d1859cb5ca6da0c484f1f37->$V8ce4b16b22b58894aa86c421e8759d = Fbcdbd6e55bcebccb5e372537a6cf1d($V22af645d1859cb5ca6da0c484f1f37->$V8ce4b16b22b58894aa86c421e8759d);
        } return $V22af645d1859cb5ca6da0c484f1f37;
    } if (!is_array($Ve34d514f7db5c8aac72a7c8191a096))
        return $Ve34d514f7db5c8aac72a7c8191a096;
    $V2cb9df9898e55fd0ad829dc202ddbd = array();
    foreach ($Ve34d514f7db5c8aac72a7c8191a096 as $V865c0c0b4ab0e063e5caa3387c1a87 => $V8277e0910d750195b448797616e091)
        $V2cb9df9898e55fd0ad829dc202ddbd[$V865c0c0b4ab0e063e5caa3387c1a87] = Fbcdbd6e55bcebccb5e372537a6cf1d($V8277e0910d750195b448797616e091);
    return $V2cb9df9898e55fd0ad829dc202ddbd;
}

function Ff30ab28a29f834c3e8f01000509956($Ve34d514f7db5c8aac72a7c8191a096) {
    if (is_string($Ve34d514f7db5c8aac72a7c8191a096)) {
        return utf8_decode($Ve34d514f7db5c8aac72a7c8191a096);
    } if (is_object($Ve34d514f7db5c8aac72a7c8191a096)) {
        $V99415f0b9a2ae6d7290f1add23e3e4 = get_object_vars($Ve34d514f7db5c8aac72a7c8191a096);
        $V22af645d1859cb5ca6da0c484f1f37 = $Ve34d514f7db5c8aac72a7c8191a096;
        foreach ($V99415f0b9a2ae6d7290f1add23e3e4 as $V8ce4b16b22b58894aa86c421e8759d => $V9e3669d19b675bd57058fd4664205d) {
            $V22af645d1859cb5ca6da0c484f1f37->$V8ce4b16b22b58894aa86c421e8759d = Ff30ab28a29f834c3e8f01000509956($V22af645d1859cb5ca6da0c484f1f37->$V8ce4b16b22b58894aa86c421e8759d);
        } return $V22af645d1859cb5ca6da0c484f1f37;
    } if (!is_array($Ve34d514f7db5c8aac72a7c8191a096))
        return $Ve34d514f7db5c8aac72a7c8191a096;
    $V2cb9df9898e55fd0ad829dc202ddbd = array();
    foreach ($Ve34d514f7db5c8aac72a7c8191a096 as $V865c0c0b4ab0e063e5caa3387c1a87 => $V8277e0910d750195b448797616e091)
        $V2cb9df9898e55fd0ad829dc202ddbd[$V865c0c0b4ab0e063e5caa3387c1a87] = Ff30ab28a29f834c3e8f01000509956($V8277e0910d750195b448797616e091);
    return $V2cb9df9898e55fd0ad829dc202ddbd;
}
