<?php
function pinyinSplit($domainBody,$domainPinyin)
{
	$pyDic = explode('|', $domainPinyin);
	$domainBody = strtolower($domainBody);
	$len = strlen($domainBody);
	$p = array_fill(0, $len + 1, $len);
	$p[$len] = 0;
	$s = array_fill(0, $len, 0);

	for($i = $len - 1;$i >= 0;$i--)
	{
		for($j = 0,$max = $len - $i;$j < $max;$j++)
		{
			if($j == 0 OR array_search(substr($domainBody, $i, $j + 1), $pyDic) !== FALSE AND $p[$i + $j + 1] + 1 < $p[$i])
			{
				$p[$i] = $p[$i + $j + 1] + 1;
				$s[$i] = $j + 1;
			}
		}
	}
	$tmp = 0;
	$result = array();
	while($tmp < $len)
	{
		$py = substr($domainBody, $tmp, $s[$tmp]);
		$tmp += $s[$tmp];
		if(array_search($py, $pyDic) !== FALSE)
		{
			array_push($result, $py);
		}
		else
		{
			return FALSE;
		}
	}
	return $result;
}


function showDomain($dn,$num)
{
	$myDn= false;
	if($num == 20)
	{
		$myDn=$dn;
	}
	else
	{
		if(strlen($dn)==$num+3)
		{
			$myDn=$dn;
		}
	}
	if($myDn)
	{
		$myDn.="\n";
	}
	return $myDn;
}

function getAddress($domain,$address)
{
	$addressArr = explode('|', $address);
	if(array_search($domain, $addressArr) !== FALSE)
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
}