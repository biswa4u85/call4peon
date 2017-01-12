<?php

error_reporting(0);
$config['upload_path'] = dirname(dirname(__FILE__)) . '/upload';
if ($_POST['module'] == 'mailbox') {
    $output_dir = $config['upload_path'] . "/mailbox/sentattachments/" . $_POST['userid'] . '/';
} elseif ($_REQUEST['module'] == 'cases') {
    $output_dir = $config['upload_path'] . "/mailbox/sentattachments/" . $_POST['userid'] . '/';
} else {
    $output_dir = $config['upload_path'] . "/users/" . $_REQUEST['companyid'] . '/' . $_REQUEST['userid'] . '/';
}

if (isset($_POST["op"]) && $_POST["op"] == "delete" && isset($_POST['name'])) {
    $fileName = $_POST['name'];
    $fileName = str_replace("..", ".", $fileName); //required. if somebody is trying parent folder files	
    $filePath = $output_dir . $fileName;
    if (file_exists($filePath)) {
        unlink($filePath);
    }
    echo $fileName;
}
?>