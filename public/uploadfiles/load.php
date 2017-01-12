<?php
$config['upload_path'] = dirname(dirname(__FILE__)).'/upload';
$output_dir = $config['upload_path']."/users/". $_REQUEST['companyid'] . '/' . $_REQUEST['userid'] . '/';
$files = scandir($dir);

$ret = array();
foreach ($files as $file) {
    if ($file == "." || $file == "..")
        continue;
    $ret[] = $file;
}

echo json_encode($ret);
?>