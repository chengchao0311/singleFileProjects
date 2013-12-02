<?php
$order_id =$_REQUEST["order_id"];
$url = "www.bhiner.com/china/china.php?mode=view_packing_list\&content=".$order_id."\&ipad=may";
$command = 'unset DYLD_LIBRARY_PATH;/Applications/MAMP/htdocs/packinglist/wkhtmltopdf.app/Contents/MacOS/wkhtmltopdf '.$url.' aaa.pdf; 2>&1';
@exec($command, $output, $result);

$output_str = implode(' ', $output);
echo $command;
echo $result,$output_str;

$print = "unset DYLD_LIBRARY_PATH;lpr aaa.pdf";
@exec($print);

?>
