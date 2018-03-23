<?php 
function generate_dir($id){
  $reval = "/" . intval($id/1000000) ."/". intval(intval($id%1000000)/1000) ."/". intval($id);
  return($reval);
}
$conn = mysql_connect("localhost","root","");
if (!$conn){
  die('Could not connect: ' . mysql_error());
}
mysql_select_db("91ant");
mysql_query("set names utf8"); //**设置字符集***
//////////////////  the bg of works ///////////////////////
$result=mysql_query("SELECT * FROM `91ant_works` ORDER BY works_id DESC", $conn);
while($row=mysql_fetch_array($result)){
  if($row["works_type"] == "photo"){
  $pl="";
  $p=mysql_fetch_array(mysql_query("SELECT photo_id FROM 91ant_photo WHERE is_deleted = 0 AND works_id = ".$row["works_id"],$conn));
  $row["cover"]="http://ate.91ant.com/Public/common/works".generate_dir($row['works_id'])."/".$p["photo_id"].".png";
  $result1=mysql_query("SELECT photo_id FROM 91ant_photo WHERE is_deleted = 0 AND works_id =".$row["works_id"],$conn);
  while($row1=mysql_fetch_array($result1)){
	  $pl.="<p style='text-align: center'><img src='http://ate.91ant.com/Public/common/works".generate_dir($row['works_id'])."/".$row1['photo_id'].".png' /></p>";
  }
  $info=$row["works_info"].$pl;
  $sql='update 91ant_works set cover="'.$row["cover"].'", info="'.htmlspecialchars_decode($info).'" where works_id='.$row["works_id"];
 //echo $sql;
	//mysql_query($sql,$conn);
  }else{
    $row["cover"]="http://ate.91ant.com/Public/common/default/tencent_video_cover.jpg";
	$info="<iframe style='height: 400px' class='video_iframe' src='http://v.qq.com/iframe/player.html?vid=".$row['video_platform_id']."&auto=0' allowfullscreen='' frameborder='0' height='100%' width='100%'></iframe>";
	$sql='update works set info="'.htmlspecialchars($info).'" where works_id='.$row["works_id"];
	//echo $sql.";<br/>";
	//mysql_query($sql,$conn);
  }
}
//////////////////  the end of works ///////////////////////

//////////////////  the bg of school ///////////////////////
$result=mysql_query("SELECT * FROM `school` ORDER BY create_timestamp ASC", $conn);
while($row=mysql_fetch_array($result)){
  $p=mysql_fetch_array(mysql_query("SELECT school_id FROM 91ant_school WHERE user_id = ".$row["user_id"],$conn));
  $logo='http://ate.91ant.com/Public/common/school'.generate_dir($p["school_id"]).'/cover.png';
  $cover="http://ate.91ant.com/Public/common/school".generate_dir($p["school_id"])."/school_cover.png";
  $sql='update school set school_id='.$p["school_id"].',logo="'.$logo.'",cover="'.$cover.'" where user_id='.$row["user_id"];
//echo $sql;
  //mysql_query($sql,$conn);
}
//"http://ate.91ant.com/public/Public/common/school".generate_dir()."/cover.png";
//////////////////  the end of school ///////////////////////


mysql_close($conn);
?>