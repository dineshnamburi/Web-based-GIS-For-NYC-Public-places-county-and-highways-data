<?php

if (!extension_loaded("MapScript")) dl("php_mapscript.so");

$request = ms_newowsrequestobj();

foreach ($_GET as $k=>$v) {
     $request->setParameter($k, $v);
}

$request->setParameter("VeRsIoN","1.0.0");
ms_ioinstallstdouttobuffer();
$oMap = ms_newMapobj("C:/ms4w/Apache/htdocs/proj1/maps/question2.map");

$new_layer =ms_newlayerobj($oMap);
$new_layer->set("type", MS_LAYER_POLYGON);
$new_layer->set("dump", 1);
$new_layer->set("status", 1);
$new_layer->set("name","question3");
$new_class = ms_newClassObj($new_layer);
$new_style = ms_newStyleObj($new_class);
$new_style-> outlinecolor->setRGB(255, 0, 0);
$new_layer->setConnectionType(MS_POSTGIS);
$new_layer->set("connection","user=dnamburi password=dinnu11136 dbname=proj1 host=127.0.0.1");
$data="the_geom from (SELECT ST_Buffer(the_geom,2000) As the_geom,gid FROM aoi) as foo using unique gid using SRID=2263";
$new_layer->set("data",$data) ;


$oMap->owsdispatch($request);
$contenttype = ms_iostripstdoutbuffercontenttype();
if ($contenttype == 'image/png')
{
   header('Content-type: image/png');
   ms_iogetStdoutBufferBytes();
}
else
{
	$buffer = ms_iogetstdoutbufferstring();
	echo $buffer;
}
ms_ioresethandlers();
?>
