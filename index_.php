<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title>JPG information viewer</title>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<!--a href="/?source=1"-->
<div class="header">
<header class="navbar navbar-default navbar-fixed-top" role="banner">
  <div class="container">
    <div class="navbar-header">
      <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a href="/" class="navbar-brand"></a>
    </div>
    <nav class="collapse navbar-collapse" role="navigation">
      <ul class="nav navbar-nav">
      </ul>
    </nav>
   </div>
</header>
<div style="margin-bottom:30px;"></div>
  <div class="container">
    <div class="page-header">
      <h1>JPG information viewer</h1>
    </div>
    <form action="index.php" method="post" enctype="multipart/form-data">
            <input type="file" name="JPG">
            <input type="submit">
        </form>
        파일은 최대 5MB만 업로드 할 수 있습니다.
    <br>
    </form>
    <pre>
        <?php
	    session_start();
            if(isset($_GET['source'])){
                echo highlight_file(__FILE__);
            	exit;
            }

    function imageanalyze($file){
        if(!is_file($file)){
            echo '<script>alert("Where is the File?")</script>';
	    exit;
        }
        else{
            return exif_read_data($file);
        }
    }

    if(isset($_FILES['JPG']) && $_FILES['JPG']['name'] != "") {
        $file = $_FILES['JPG'];

        $upload_directory = './uploads/';
        $ext_str = "jpg";
        $allowed_extensions = explode(',', $ext_str);

        $max_file_size = 5242880;
        $ext = substr($file['name'], strrpos($file['name'], '.') + 1);

        if(!in_array($ext, $allowed_extensions)) {
            echo "<script>jpg파일만 업로드 할 수 있습니다.')</script>";
	    exit;
        }

        if($file['size'] >= $max_file_size) {
            echo "<script>alert('파일은 5MB 까지만 업로드 가능합니다.')</script>";
	    exit;
        }
	
        $path = $upload_directory.session_id();
	mkdir($path,0777);
	$updir = $path.'/'.$file['name'];
	if(move_uploaded_file($file['tmp_name'],$updir)) {
        	$infor = imageanalyze($updir); 
	#   $if(imageanalyze($updir)){
	    	#$infor = imageanalyze($updir);
	#	echo "<script>alert('파일 업로드 성공!')</script>";
            #	echo "<img src='$updir'>";
	  ##  }
	 #   else{
	#	die("fuckkkkkkkkkkkkkkkkkkkkkk");
        #
	    #}
	}
	else{
            echo "<script>alert('업로드 에러!')</script>";
	    exit;
        }
    ?>
    </pre>
    <pre>
	<?php	
		if(isset($infor)){
			$size = round($infor['FileSize']/1024,1);
			echo "<br>파일명 : {$infor['FileName']}<br>";
			echo "파일 크기 : {$size}KB<br>";
			if(array_key_exists('DateTimeOriginal',$infor)){
				echo "촬영 시간 : {$infor['DateTimeOriginal']}<br>";
			}	
			else{	
				$date = date("Y-m-d H:i:s", $infor['FileDateTime']);
				echo "업로드 시간 : {$date}<br>";
			}
			if(array_key_exists('Model',$infor)&&isset($infor['Model'])){
				preg_replace($infor['Make'],$infor['Model'],'');
				echo "카메라 모델 : {$infor['Model']}<br>";
			}
		}
	?>
<div id="row">
<div class="col-md-12">

