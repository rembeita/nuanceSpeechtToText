<?php
function processResultsSync($m)
{
        //$status = array_values(json_decode($respResults, true))[1]["status"];
        //$process_respResults = array_values(json_decode($respResults, true))[1]["name"];
        // We'll simply display the response details in an HTML table

	$json=json_decode($m, true);
	$result=$json["results"][0]["alternatives"][0]["transcript"];
        echo '
        <div class="element-input">
                        <div class="item-cont" align="center">
                                <table>
                                <tr><td><font size=6><b>Transcribe</b></font></td></tr>
                                </table>
                        </div>
        </div>
        <div class="element-input">
                        <div class="item-cont" align="center">
                                <table>
                                <tr><td>' . $result . '</td></tr>
                                </table>
                        </div>
        </div>
        ';
        // Done.
}
function processResultsASync($m)
{
        //$status = array_values(json_decode($respResults, true))[1]["status"];
        //$process_respResults = array_values(json_decode($respResults, true))[1]["name"];
        // We'll simply display the response details in an HTML table
	$result=$m;
        echo '
        <div class="element-input">
                        <div class="item-cont" align="center">
                                <table>
                                <tr><td><font size=6><b>Transcribe</b></font></td></tr>
                                </table>
                        </div>
        </div>
        <div class="element-input">
                        <div class="item-cont" align="center">
                                <table>
                                <tr><td>' . $result . '</td></tr>
                                </table>
                        </div>
        </div>
        ';
        // Done.
}

function getBucketFiles()
{
	 global $listFiles;
	 $bucket_list = shell_exec("sh getlist.sh");
	 $json_bucket=json_decode($bucket_list, true);
//                $selected = ($language == $v[1]) ? "selected" : "";
//                $languages_dropdown .= '<option '. $selected .' value="'. $v[1] .'">'. $v[0] .' - '. $v[1] .'</option>';
	 //var_dump($json_bucket);
//                                                <OPTION VALUE="LINEAR16">LINEAR16-PCM</OPTION>
 //                                               <OPTION VALUE="FLAC">FLAC</OPTION>

	foreach( $json_bucket as $key=>$val)
    	{	
        	 $listFiles .= '<option value="' . $val["name"] .'">'. $val["name"] . '</option>';
    	}     
}
getBucketFiles();

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Google Speech Uploader</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="blurBg-false" style="background-color:#EBEBEB">

<!-- Display our Web Page with a Form to collect HTTP Client Parameters -->


<!-- Start Formoid form-->
<link rel="stylesheet" href="/googleapi/resources/formoid-solid-blue.css" type="text/css" />
<script type="text/javascript" src="/static/jquery.min.js"></script>
<form class="formoid-solid-blue" style="background-color:#FFFFFF;font-size:14px;font-family:'Roboto',Arial,Helvetica,sans-serif;color:#34495E;max-width:900px;min-width:150px" method="post" action="index.php" enctype="multipart/form-data">
	<div class="title">
		<h2 style="text-align: center">Google Speech Uploader</h2>
	</div>
	<div class="element-input">
		<label class="title"></label>
		<!-- audio file -->
			<div class="item-cont" align="center">
				<input type="hidden" name="translate" value="yes">
				<table>
				<tr><td>Google Speech:&nbsp;</td>
				<td><a href="https://console.cloud.google.com/storage/browser/translatespeech/?project=speechtestnuance">Google Storage</a>
				</td></tr>
				<tr><td>Files:&nbsp;</td><td>
					<select name="filesbucket" style="width:220;">
					<?php echo $listFiles; ?>
					</select>
				</td></tr>
				<!-- language -->
				<tr><td colspan="2"><font color="green"><br>Select the Language and Codec.</font></td></tr>
				<tr><td>Language:&nbsp;</td><td>
					<select name="language" style="width:220;">
						<OPTION VALUE="en-US">English</OPTION>
					</select>
				</td></tr>
				<tr><td>Codec:&nbsp;</td><td>
					<select name="codec" style="width:220;">
						<OPTION VALUE="LINEAR16">LINEAR16-PCM</OPTION>
						<OPTION VALUE="FLAC">FLAC</OPTION>
					</select>
				</td></tr>
				<!-- codec -->
				<tr><td>Rate:&nbsp;</td><td>
					<select name="rate" style="width:220;">
						<OPTION VALUE="16000">16000</OPTION>
						<OPTION VALUE="41000">41000</OPTION>
						<OPTION VALUE="8100">8100</OPTION>
					</select>
				</td></tr>
				<!-- codec -->

				</table>

			</div>
	</div>




<?php
if( isset($_POST['translate']) ) 
{
	//getting variables from Form
	$language = $_POST["language"];
	$codec = $_POST["codec"];
	$rate = $_POST["rate"];
	$uploaded_file = $_FILES["audioFile"]["tmp_name"];
	$audioFile = $_POST["filesbucket"];
	$bucket_dir="gs://translatespeech/";
        echo '
        <div class="element-input">
                        <div class="item-cont" align="center">
                                <table>
                                <tr><td><font size=6><b>File Details</b></font></td></tr>
                                </table>
                        </div>
        </div>
        <div class="element-input">
                        <div class="item-cont" align="center">
                                <table>
                                <tr><td>Audio File: ' . $audioFile . ' </td></tr>
                                <tr><td>Language: ' . $language . ' </td></tr>
                                <tr><td>Codec: ' . $codec . '</td></tr>
                                <tr><td>Rate: ' . $rate . ' </td></tr>
                                </table>
                        </div>
        </div>';
	
	//Execute bash script with python program to translate audio
	//$resp_info = shell_exec(" sh script.sh $bucket_dir$audioFile $codec $rate $language");
	//echo "sh async.sh $bucket_dir$audioFile $codec $rate $language";
	$resp_info = shell_exec(" sh async.sh $bucket_dir$audioFile $codec $rate $language");
	//var_dump($resp_info);
         //processResultsSync($resp_info);
         processResultsASync($resp_info);
}
?>

<div class="submit">
	<input type="submit" name="commit" value="Translate"/>
</div>

</form>
</body>
</html>
