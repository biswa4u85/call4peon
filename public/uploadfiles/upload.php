<?php

$config['upload_path'] = dirname(dirname(__FILE__)) . '/upload';
$module = isset($_REQUEST['module']) ? $_REQUEST['module'] : '';

if ($module == 'hotel_images') {
    $output_dir = $config['upload_path'] . "/hotels/" . $_REQUEST['companyid'] . '/' . $_REQUEST['hotelid'] . '/';
} else if ($module == 'mailbox') {
    $output_dir = $config['upload_path'] . "/mailbox/sentattachments/" . $_REQUEST['userid'] . '/';
} elseif ($module == 'cases') {
    $output_dir = $config['upload_path'] . "/mailbox/sentattachments/" . $_REQUEST['userid'] . '/';
} else {
    $output_dir = $config['upload_path'] . "/users/" . $_REQUEST['companyid'] . '/' . $_REQUEST['userid'] . '/';
}

createfolder($output_dir);
//    print_r($_REQUEST['iNoteId']);
if (isset($_FILES["myfile"])) {
    $ret = array();

//	This is for custom errors;	
    /* 	$custom_error= array();
      $custom_error['jquery-upload-file-error']="File already exists";
      echo json_encode($custom_error);
      die();
     */
    $error = $_FILES["myfile"]["error"];
    //You need to handle  both cases
    //If Any browser does not support serializing of multiple files using FormData() 
    if (!is_array($_FILES["myfile"]["name"])) { //single file
        if (isset($type)) {
            $_FILES["myfile"]["name"] = $time . '_' . $_FILES["myfile"]["name"];
        }
        $fileName = $_FILES["myfile"]["name"];

        move_uploaded_file($_FILES["myfile"]["tmp_name"], $output_dir . $fileName);
        $ret[] = $fileName;
    } else {  //Multiple files, file[]
        $fileCount = count($_FILES["myfile"]["name"]);
        for ($i = 0; $i < $fileCount; $i++) {
            if (isset($type)) {
                $_FILES["myfile"]["name"][$i] = $time . '_' . $_FILES["myfile"]["name"][$i];
            }
            $fileName = $_FILES["myfile"]["name"][$i];
            move_uploaded_file($_FILES["myfile"]["tmp_name"][$i], $output_dir . $fileName);
            $ret[] = $fileName;
        }
    }
    echo json_encode($ret);
}

function createfolder($path) {
    $site_path = dirname(dirname(__FILE__)) . '/upload';
    $res = '';
    $pathfolder = @explode("/", str_replace($site_path, "", $path));
    $realpath = "";
    for ($p = 0; $p < count($pathfolder); $p++) {
        if ($pathfolder[$p] != '') {
            $realpath = $realpath . $pathfolder[$p] . "/";
            $makefolder = $site_path . "/" . $realpath;
            if (!is_dir($makefolder)) {
//                    $makefolder = @mkdir($makefolder, 0777);
//                    @chmod($makefolder, 0777);

                $oldUmask = umask(0);
                $res = @mkdir($makefolder, 0777);
                @chmod($makefolder, 0777);
                umask($oldUmask);
            }
        }
    }

    return $res;
}

?>