<?php 
function generate_dir($id){
  $reval = "/" . intval($id/1000000) ."/". intval(intval($id%1000000)/1000) ."/". intval($id);
  return($reval);
}
$conn = mysql_connect("119.23.148.171","root","mysql@91ant.com");
if (!$conn){
  die('Could not connect: ' . mysql_error());
}
mysql_select_db("91ant");
mysql_query("set names utf8"); //**设置字符集***
$result=mysql_query("SELECT * FROM `91ant_works` ORDER BY works_id DESC", $conn);
echo mysql_num_rows($result);
while($row=mysql_fetch_array($result)){
  if($row["works_type"] == "photo"){
    $photo=mysql_result(mysql_query("SELECT photo_id FROM 91ant_photo WHERE is_deleted = 0 AND works_id = ".$row["works_id"],$conn),0);
    $row["cover"]="http://ate.91ant.com/Public/common/works".generate_dir($row['works_id'])."/".$photo.".png";
  }else{
    $row["cover"]="http://ate.91ant.com/Public/common/default/tencent_video_cover.jpg";
  }
  //print_r($row);
}
mysql_close($conn);
?>