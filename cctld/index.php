<?php
$sm = $domainPinyin = $domainAddress = '';
include_once('config.php');
include_once('fun.php');
$name =  isset($argv[1]) ?$argv[1] :false;//文件名
$data =  isset($argv[2]) ?$argv[2] :false;//日期
if($name==false)
{
	echo "how to use :\n php index.php filename date length domainType(1:纯数字,2:纯字母,3:声母4：双拼 10:all)";
	exit;
}
$num =  isset($argv[3]) ?$argv[3] :20;//长度
$strType = isset($argv[4]) ?$argv[4] :3;//是否数字 1：数字 2：字符 3 :全声母 4:双拼 10：所有
$txt = file_get_contents($name);
$arr = explode("\n",$txt);
foreach($arr as $v)
{
	$v = strtolower($v);
	if(stripos($v,'.cc') && stripos($v, "-")===false && stripos($v, $data))
	{
		$dn=explode(":", $v)[0];
		$dnBody = str_replace(".cc", "", $dn);
		if($strType == 1 && is_numeric($dnBody))
		{
			echo showDomain($dn,$num);
		}
		if($strType == 2 && preg_match("/^[a-z]*$/i",$dnBody))
		{
			echo showDomain($dn,$num);
		}
		if($strType == 3)
		{
			$smArr = explode("|", $sm);
			$strArr = str_split($dnBody);
			$in = true;
			foreach ($strArr as $value)
			{
				if(in_array(strtolower($value),$smArr)===false)
				{
					$in = false;
					break;
				}	
			}
			if($in)
			{
				echo showDomain($dn,$num);
			}
		}
		if($strType == 4)
		{
			$py = pinyinSplit($dnBody,$domainPinyin);
			if($py && (count($py) == $num))
			{
				echo $dn."\n";
			}
		}
		if($strType==10)
		{
			echo showDomain($dn,$num);
		}
	}
}