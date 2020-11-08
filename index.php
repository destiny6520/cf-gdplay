<?php 

?>
<!DOCTYPE html>
<html>
<head>
	<title>CFPlayer</title>
	<meta name="robots" content="noindex">
	<link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon" />
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
	<script type="text/javascript" src="https://content.jwplatform.com/libraries/0P4vdmeO.js"></script>
	<script type="text/javascript">jwplayer.key="IMtAJf5X9E17C1gol8B45QJL5vWOCxYUDyznpA==";</script>
	<style type="text/css" media="screen">html,body{padding:0;margin:0;height:100%}#cf-player{width:100%!important;height:100%!important;overflow:hidden;background-color:#000}</style>
</head>
<body>

<?php 
		error_reporting(0);
		
		$data = (isset($_GET['data'])) ? $_GET['data'] : '';

		if ($data != '') {
			
			include_once 'config.php';

			$data = json_decode(decode($data));

			$link = (isset($data->link)) ? $data->link : '';

			$sub = (isset($data->sub)) ? $data->sub : '';

			$poster = (isset($data->poster)) ? $data->poster : '';

			$tracks = '';
			
			foreach ($sub as $key => $value) {
			    $tracks .= '{ 
						        file: "'.$value.'", 
						        label: "'.$key.'",
						        kind: "captions"
							   },';
			}

			include_once 'curl.php';

			$curl = new cURL();

		    $sources = '[{"label":"HD","type":"video\/mp4","file":"'.$link.'"}]';

			$result = '<div id="cf-player"></div>';

			$data = 'var player = jwplayer("cf-player");
						player.setup({
							sources: '.$sources.',
							aspectratio: "16:9",
							startparam: "start",
							primary: "html5",
							autostart: false,
							preload: "auto",
                            aboutlink: "https://fb.com/delta.web.id",
                            abouttext: "CFPlayer",
							image: "'.$poster.'",
						    captions: {
						        color: "#f3f368",
						        fontSize: 16,
						        backgroundOpacity: 0,
						        fontfamily: "Helvetica",
						        edgeStyle: "raised"
						    },
						    tracks: ['.$tracks.']
						});
			            player.on("setupError", function() {
			              swal("Server Error!", "Please PM Me to fix it. Thank you!", "error");
			            });
						player.on("error" , function(){
							swal("Player Error!", "Please PM Me to fix it. Thank you!", "error");
						});';
			
			$packer = new Packer($data, 'Normal', true, false, true);

			$packed = $packer->pack();

			$result .= '<script type="text/javascript">' . $packed . '</script>';

			echo $result;

		} else echo 'Empty link!';

?>

</body>
</html>