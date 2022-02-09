<?php

$con=mysqli_connect($DB['server'],$DB['user'],$DB['password'],$DB['DB']);

if(!$con){
		DBerror('DB connect error',mysqli_error,false);
}

function DBerror($query,$msg,$errno){
	echo "<b> MySQL error".$errno."<br>".htmlspecialchars($msg)."<br>".$query."<hr>";
}

function Query($con,$sql,$param=false){

	if($param){
		if(!empty($param)){
			foreach($param as $v){
			$v=quote($v);
			}
			$sql=vsprintf(str_replace("?","%s",$sql),$param);
		}
	}

	$res=mysqli_query($con,$sql);
	if(!$res){
		DBerror($sql,mysqli_error($con),mysqli_errno($con));
	}else{
		return $res;
	}
}

function FetchRow($data){
	$res=mysqli_fetch_array($data,MYSQLI_ASSOC);
	return $res;
}

function FQuery($sql,$param=false){
	global $con;
	$row=FetchRow(Query($con,$sql,$param));
	return $row;
}
//что бы получить несколько записей нам нам нужно указать другую фукнцию
function FQueryAllRows($sql,$param=false){
	global $con;

	$q=Query($con,$sql,$param);
	while($a=FetchRow($q))$row[]=$a;

	return $row;
}

function Insert($table,$data){
	global $con;
	$table=trim($table);
	$fields='';
	$values='';
	while(list($fname,$value)= each($data)){
		$fields.='`'.$fname.'`,';
		$values.=quote($value).',';
	}
	$fields=rtrim($fields,',');
	$values=rtrim($values,',');
	$sql="Insert INTO ".$table."(".$fields.") VALUES (".$values.")";
	return Query($con,$sql);
}
function quote($value,$a=true){
	global $con;
		$value="'".mysqli_real_escape_string($con,$value)."'";
	return $value;
}

function getInsertID(){
	global $con;
	return mysqli_insert_id($con);
}


function Update($table,$data,$option=''){
	global $con;
	$fields='';

	while( list($fname,$value)=each($data)){
		$fields.="$fname=  ".quote($value).',';
	}

	$fields=trim($fields,',');
	$sql="UPDATE " .$table." SET " .$fields. ' ' .$option;

	//return $sql;

	$res=Query($con,$sql);

	return $res;

}
