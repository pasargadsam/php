<html>
<head>
<title>pania crawler 01</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">

$(document).ready(function(){

  // ;)

});

</script>
<style type="text/css">
	body{
		padding: 25px;
		margin: 25px;
	}
</style>
</head>
<body>

<?php

include_once('simple_html_dom.php');

$html = file_get_html('http://shop.daryasoft.com/');
$ret = $html->find('a');
if (ob_get_level() == 0) ob_start();

$i=0;
$c=0;
foreach($ret as $value){
			if(preg_match('/^\//', $value->href)){
				$i++;
				$c++;
				print '<font color="green">'.$c.' '.$i.' http://shop.daryasoft.com'.$value->href.'</font><br />'."\n".'<script type="text/javascript">window.scroll(0,document.body.scrollHeight);</script>';
				
				$html2 = file_get_html('http://shop.daryasoft.com'.$value->href);
				$ret2 = $html->find('a');


				foreach($ret2 as $value2){
					if(preg_match('/^\//', $value2->href)){
						$i++;
						print '<font style="margin-left:25px;" color="orange">'.$i.' http://shop.daryasoft.com'.$value2->href.'</font><br />'."\n".'<script type="text/javascript">window.scroll(0,document.body.scrollHeight);</script>';
						ob_flush();
						flush();
						sleep(1);
					}elseif(preg_match('/^index/', $value2->href)){
						$i++;
						print '<font style="margin-left:25px;" color="orange">'.$i.' http://shop.daryasoft.com/'.$value2->href.'</font><br />'."\n".'<script type="text/javascript">window.scroll(0,document.body.scrollHeight);</script>';
						ob_flush();
						flush();
						sleep(1);						
					}
				}
				
				ob_flush();
				flush();
				sleep(1);
			}elseif(preg_match('/^index/', $value->href)){
				$i++;
				$c++;
				print '<font color="green">'.$c.' '.$i.' http://shop.daryasoft.com/'.$value->href.'</font><br />'."\n".'<script type="text/javascript">window.scroll(0,document.body.scrollHeight);</script>';
				
				$html2 = file_get_html('http://shop.daryasoft.com/'.$value->href);
				$ret2 = $html->find('a');

					foreach($ret2 as $value2){
						if(preg_match('/^\//', $value2->href)){
							$i++;
							print '<font style="margin-left:25px;" color="orange">'.$i.' http://shop.daryasoft.com'.$value2->href.'</font><br />'."\n".'<script type="text/javascript">window.scroll(0,document.body.scrollHeight);</script>';
							ob_flush();
							flush();
							sleep(1);
						}elseif(preg_match('/^index/', $value2->href)){
							$i++;
							print '<font style="margin-left:25px;" color="orange">'.$i.' http://shop.daryasoft.com/'.$value2->href.'</font><br />'."\n".'<script type="text/javascript">window.scroll(0,document.body.scrollHeight);</script>';
							ob_flush();
							flush();
							sleep(1);							
						}
					}

				ob_flush();
				flush();
				sleep(1);				
			}

}

ob_end_flush();


?>



</body>
</html>

