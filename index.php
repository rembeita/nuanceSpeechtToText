<?php
function processResults($m)
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
                                <tr><td><font size=6><b>Translation</b></font></td></tr>
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
				<tr><td>Audio File: </td><td><input type="file" name="audioFile"></td></tr>
				<!-- language -->
				<tr><td colspan="2"><font color="green"><br>Select the Language and Codec.</font></td></tr>
				<tr><td>Language:&nbsp;</td><td>
					<select name="language" style="width:220;">
						<OPTION VALUE="en-US">English</OPTION>
					</select>
				</td></tr>
				<tr><td>Codec:&nbsp;</td><td>
					<select name="codec" style="width:220;">
						<OPTION VALUE="LINEAR16">LINEAR16</OPTION>
						<OPTION VALUE="FLAC">FLAC</OPTION>
						<OPTION VALUE="PCM">PCM</OPTION>
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


<div class="submit">
	<input type="submit" name="commit" value="Translate"/>
</div>

</form>
</body>
</html>


<?php
if( isset($_POST['translate']) ) 
{
	//getting variables from Form
	$language = $_POST["language"];
	$codec = $_POST["codec"];
	$rate = $_POST["rate"];
	$uploaded_file = $_FILES["audioFile"]["tmp_name"];
	$audioFile = $_FILES["audioFile"];

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
                                <tr><td>Audio File: </td></tr>
                                <tr><td>Language: ' . $language . ' </td></tr>
                                <tr><td>Codec: ' . $codec . '</td></tr>
                                <tr><td>Rate: ' . $rate . ' </td></tr>
                                </table>
                        </div>
        </div>';
         $contentLength = (strlen($audioFile['name']) > 0) ?  $audioFile['size'] : 0;
         if( !$contentLength )
       	 {
           	echo "<br><br>Please provide an audio file<br><br>";
         }
         else
         {
		//Execute bash script with python program to translate audio
		$resp_info = shell_exec(" sh script.sh $uploaded_file $codec $rate $language");
	 }
         processResults($resp_info);
}
?>
