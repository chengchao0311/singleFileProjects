<?php
//error_reporting(E_ALL);
//ini_set( 'display_errors','1');

function url2array($url){
	$xmldata = shell_exec("curl ".$url);
	return xml2array($xmldata);
}

function xml2array($xmldata){
	$res = @simplexml_load_string($xmldata,NULL,LIBXML_NOCDATA);
	return json_decode(json_encode($res),true);
}

function get_single_video_reurl($video_list_array, $index){
	return 	$video_list_array['videolist']['video'][$index]['reurl'];
}


function get_single_video_name($video_list_array, $index){
	return 	$video_list_array['videolist']['video'][$index]['@attributes']['videoname'];
}

function get_single_video_array($video_list_array, $index){
	$video_reurl = get_single_video_reurl($video_list_array, $index);
	$video_name = get_single_video_name($video_list_array,$index);
	return $video = array(
	    "video_reurl" => $video_reurl,
	    "video_name" => $video_name,
	);
}

function get_video_files_xml_url($news, $index){
	$video_array = url2array($news[$index]['video_reurl']);

	return $video_array["videolist"]["video"]["coderate"]["videourl"]["@attributes"]["playurl"];
}

function get_video_file_url($video_files_xml_url){
	$reader = new XMLReader();
	$reader->open($video_files_xml_url);
	$video_first_file_url = "";
	while ($reader->read()) {
		if($reader->name == "url"){
			return $video_first_file_url = $reader->getAttribute("link");
		}
	}
}


$get_video_list_url = "http://ims.veryhd.net/veryhd4.0/youku.php\?myvideo\=1\&classid\=91\&type\=%E8%B5%84%E8%AE%AF\&pagesize\=100";
$video_list_array = url2array($get_video_list_url);

$news = array();
for($i=0, $size=count($video_list_array['videolist']['video']); $i<$size;$i++){
	$video = get_single_video_array($video_list_array, $i);
	array_push($news, $video);
}

for($i=0, $size=count($news);$i<$size;$i++){
	$video_files_xml_url = get_video_files_xml_url($news, $i);
	$video_file_url = get_video_file_url($video_files_xml_url);
	$news[$i]['play_url'] = $video_file_url;
}


for($i=0, $size=count($news);$i<$size;$i++){
	$herf = '<a href="'.$news[$i]["play_url"].' target="video">'.$news[$i]["video_name"].'</a><br>';
	echo $herf;
}

die();
?>
