<?php



$dir = (isset($_GET['dir']))? htmlspecialchars($_GET['dir']) : ".";


$act = isset($_GET['act'])? htmlspecialchars($_GET['act']): "go";

switch ($act){

    case "go":
        $data = getContent($dir);
        $data['dir']=$dir;
        $path_parts = pathinfo($dir);
        break;

    case "back":
        $path_parts = pathinfo($dir);
        $dirname= $path_parts['dirname'];


        $data = getContent($dirname);
        $data['dir']=$dirname;
        break;
    default:
        die("ERROR");

}


function getContent($path) {

    $data = array(
        'folders' =>array(),
        'files' =>array()
    );

    if(!file_exists($path)){
       die("err ha-ha :)");
    }

    if ($dir = opendir($path."/"))  {

        while (false !== ($file = readdir($dir))) {
            if($file == "." || $file == ".." ){
                continue;
            }
           if(is_dir($path."/".$file)){
                $data['folders'][]=$file;
            }if(is_file($path."/".$file)){
               $data['files'][]=$file;
            }
        }
        closedir($dir);
    }

    return $data;
}


?>


<!doctype html>
<html>
<head>
     <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="css/style.css">
    <meta charset="utf-8">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <div class="row">

        <div class="col-md-4 mg">
            <h3 id="dirname"><small>dir name: </small><?= $data['dir']."/"?></h3>
            <hr>
            <ul class="non">
                <li><a href="?dir=<?=$data['dir'] ?>&act=back">.. <small>back</small></a></li>
            </ul>

            <ul class="non">
                <?php foreach($data['folders'] as $folder):?>
                     <li>
                         <span class="glyphicon glyphicon-folder-open"></span>
                         <a href="?dir=<?=$data['dir']."/".$folder?>&act=go"><?=$folder?></a>
                     </li>
                <?php endforeach;?>
            </ul>
            <hr>
            <h3>Files</h3>
            <ul class="non">
                <?php foreach($data['files'] as $file):?>
                    <li>
                        <span class="glyphicon glyphicon-file"></span>
                        <?= $file ?> <a href="download.php?file=<?= $data['dir']."/".$file?>">download</a>
                        <a href="delete.php?file=<?= $data['dir']."/".$file?>">delete</a>
                    </li>
                <?php endforeach;?>

            </ul>

        </div>



    </div>
</div>



</body>
</html>





