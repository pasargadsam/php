<?php

include_once('simple_html_dom.php');

$html = file_get_html('http://www.avval.ir/Directory/');
$ret = $html->find('a');
if (ob_get_level() == 0) ob_start();

$i=0;
$c=0;
foreach($ret as $value){
			if(preg_match('/^\//', $value->href)){
				$i++;
				$c++;
				print '<font color="green">'.$c.' '.$i.' http://www.avval.ir/Directory/'.$value->href.'</font><br />'."\n".'<script type="text/javascript">window.scroll(0,document.body.scrollHeight);</script>';

				$html2 = file_get_html('http://shop.daryasoft.com'.$value->href);
				$ret2 = $html->find('a');


				foreach($ret2 as $value2){
					if(preg_match('/^\//', $value2->href)){
						$i++;
						print '<font style="margin-left:25px;" color="orange">'.$i.' http://www.avval.ir/Directory/'.$value2->href.'</font><br />'."\n".'<script type="text/javascript">window.scroll(0,document.body.scrollHeight);</script>';
						ob_flush();
						flush();
						sleep(1);
					}elseif(preg_match('/^index/', $value2->href)){
						$i++;
						print '<font style="margin-left:25px;" color="orange">'.$i.' http://www.avval.ir/Directory/'.$value2->href.'</font><br />'."\n".'<script type="text/javascript">window.scroll(0,document.body.scrollHeight);</script>';
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
				print '<font color="green">'.$c.' '.$i.' http://www.avval.ir/Directory/'.$value->href.'</font><br />'."\n".'<script type="text/javascript">window.scroll(0,document.body.scrollHeight);</script>';

				$html2 = file_get_html('http://www.avval.ir/Directory/'.$value->href);
				$ret2 = $html->find('a');

					foreach($ret2 as $value2){
						if(preg_match('/^\//', $value2->href)){
							$i++;
							print '<font style="margin-left:25px;" color="orange">'.$i.' http://www.avval.ir/Directory/'.$value2->href.'</font><br />'."\n".'<script type="text/javascript">window.scroll(0,document.body.scrollHeight);</script>';
							ob_flush();
							flush();
							sleep(1);
						}elseif(preg_match('/^index/', $value2->href)){
							$i++;
							print '<font style="margin-left:25px;" color="orange">'.$i.' http://www.avval.ir/Directory/'.$value2->href.'</font><br />'."\n".'<script type="text/javascript">window.scroll(0,document.body.scrollHeight);</script>';
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