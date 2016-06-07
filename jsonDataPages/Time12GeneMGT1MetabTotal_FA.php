<?php 
header('Content-Type: application/json');
// you should get params from url
//

$data = file_get_contents("http://www.metnetdb.org/PMR/api_v1/getResultCoanalysis.php?expid=54d595cce9b6710f2c9658ee&pid=54d595cce9b6710f2c9658f0&mid=54d5a645e9b6712c503bad09&genename=MGT1&hours=12");
echo $data;
?>
