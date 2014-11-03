<?php
/*Name   ：Debug 自定义类
 *Author ：lizhi	
 *静态调用方式
 *示例：显示当前的错误位置行数
	1. error_info::error_line(__LINE__);
	或者 call_user_func(array('error_info','error_line'),__LINE__);
	
 *示例：页面输出参数（数组,json,字符串）
	2.error_info::error_param($test);
	或者 call_user_func(array('error_info','error_param'),$test);	
 *
 *@param 1 => 自定义一维数组模版输出
 *@param 2 => 自定义二维数组模版输出
 *@param 2 => Printf_r 页面输出
 *
 *
 */
class error_info
{
	public static $params=array('info'=>'参数为空');
	public static $htmlheader='<html><head><meta charset="UTF-8"><title>PHP 异常捕获输出界面</title><style>html,body {text-align:left;font-family:"\5fae\8f6f\96c5\9ed1";margin:0 auto;padding:0;background:#44cef6;color:#333;font-size:14px;text-shadow: 0px 1px 1px #999;}</style></head><body>';
	public static $htmlfooter='</body></html>';
	
	/*显示当前行号*/
	static function error_line($line=__LINE__)
	{

		//echo self::$htmlheader;
		echo '<h3 style="width:100%;height:60px;background:#44cef6;color:#fff;font-weight:700;line-height:60px;text-indent:1em;padding:0;margin:0;font-size:18px;text-shadow: 0px 1px 1px #999;">当前断点位置：';
		echo $line;
		echo "行</h3>";
		echo '<HR style="FILTER: progid:DXImageTransform.Microsoft.Shadow(color:#987cb9,direction:145,strength:15);margin:25px auto 0;" width="98%" color=#987cb9 SIZE=5>';
	}
	/*输出参数*/
	static function error_param($param="",$way=null)
	{
		$color[1]="#808080";$color[2]="#44cef6";$color[3]="#ff461f";
		$color[4]="#00bc12";$color[5]="#bbcdc5";$color[6]="#60281e";
		$color[7]="#e29c45";$color[8]="#a98175";$color[9]="#cca4e3";
		$colornum=mt_rand(1,9);
		echo '<div style="clear:both;width:98%;min-height:60px;background:'.$color[$colornum].';color:#000;font-weight:700;line-height:25px;text-indent:1em;padding: 10px 0;border-radius:8px;margin:20px auto;overflow: hidden !important;_overflow: visible;font-size:18px;text-shadow: 0px 1px 1px #999;"><b><p>当前参数输出：</p></b><p>';
		$info=$param?$param:self::$params;
		if($way==null)
		{
			if(is_array($info))
			{
				$arraylev=error_info::arrayLevel($info);
				switch ($arraylev)
				{
					case 1	:
							$way=1;
							break;
					case 2	:
							$way=2;
							break;
					default :
							$way=3;
							break;
				}
			}
			else if(error_info::analyJson($info)!==FALSE)
			{
				$isjson=error_info::analyJson($info);
				$arraylev=error_info::arrayLevel($isjson);
				switch ($arraylev)
				{
					case 1	:
							$way=10;
							break;
					case 2	:
							$way=11;
							break;
					default :
							$way=10;
							break;
				}
			}
			else
			{
				$way=4;
			}
		}
		switch ($way)
		{
			case 1:	//一维数组
					$i=0;
					echo "<p>数组解析输出</p>";
					echo '<div style="clear:both;line-height:30px;font-size:18px;text-shadow: 0px 1px 1px #999;"><div style="float:left;width:100px;height:30px;">【序号】</div><div style="float:left;width:100px;height:30px;">数组键名</div><div style="float:left;width:80px;height:30px;text-align:center;"> => </div><div style="float:left;width:100px;height:30px;margin:0 0 0 20px;">数组键值</div></div>';
					foreach($info as $key => $value)
					{
						echo '<div style="clear:both;line-height:30px;"><div style="float:left;width:100px;height:30px;">【'.$i.'】</div><div style="float:left;width:100px;height:30px;">'.$key.'</div><div style="float:left;width:80px;height:30px;text-align:center;"> => </div><div style="float:left;width:100px;height:30px;margin:0 0 0 20px;">'.$value."</div></div>";
						$i++;
					}
					break;
			case 2:	//二维数组
					$i=0;
					echo "<p>数组解析输出</p>";
					echo '<div style="clear:both;line-height:30px;font-size:18px;text-shadow: 0px 1px 1px #999;"><div style="float:left;width:100px;height:30px;">【序号】</div><div style="float:left;width:100px;height:30px;">数组键名</div><div style="float:left;width:80px;height:30px;text-align:center;"> 〓〉 </div><div style="float:left;width:100px;height:30px;margin:0 0 0 20px;">数组键值</div></div>';
					foreach($info as $key => $value)
					{
						if(is_array($value))
						{
							echo '<div style="clear:both;line-height:30px;"><div style="float:left;width:100px;height:30px;">【'.$i.'】</div><div style="float:left;width:100px;height:30px;">'.$key.'</div><div style="float:left;width:80px;height:30px;text-align:center;"> 〓〉 </div><div style="float:left;width:100px;height:30px;margin:0 0 0 20px;">↓【子数组】</div></div>';
							
							foreach($value as $keys => $values)
							{
								echo '<div style="clear:both;line-height:30px;color:#fff;"><div style="float:left;width:100px;height:30px;">【'.$key.'】</div><div style="float:left;width:100px;height:30px;">'.$keys.'</div><div style="float:left;width:80px;height:30px;text-align:center;"> => </div><div style="float:left;width:100px;height:30px;margin:0 0 0 20px;">'.$values.'</div></div>';
							}
						}
						else
						{
							echo '<div style="clear:both;line-height:30px;"><div style="float:left;width:100px;height:30px;">【'.$i.'】</div><div style="float:left;width:100px;height:30px;">'.$key.'</div><div style="float:left;width:80px;height:30px;text-align:center;"> 〓〉 </div><div style="float:left;width:100px;height:30px;margin:0 0 0 20px;">'.$value.'</div></div>';
						}
						
						$i++;
					}
					break;		
			case 3:
					echo "<p>数组原型解析输出（Print_r）</p>";
					echo "<p>".$info."</p>";
					break;
			case 4:
					echo "<p>字符串解析输出（Echo）</p>";
					echo "<p>".$info."</p>";
					break;
			case 5:
					var_dump($info);
					break;
			case 10://解析json一维数组
					$i=0;
					echo "<p>Json解析输出</p>";
					echo '<div style="clear:both;line-height:30px;"><div style="float:left;width:100px;height:30px;">【序号】</div><div style="float:left;width:100px;height:30px;">数组键名</div><div style="float:left;width:80px;height:30px;text-align:center;"> => </div><div style="float:left;width:100px;height:30px;margin:0 0 0 20px;">数组键值</div></div>';
					foreach($isjson as $key => $value)
					{
						echo '<div style="clear:both;line-height:30px;"><div style="float:left;width:100px;height:30px;">【'.$i.'】</div><div style="float:left;width:100px;height:30px;">'.$key.'</div><div style="float:left;width:80px;height:30px;text-align:center;"> => </div><div style="float:left;width:100px;height:30px;margin:0 0 0 20px;">'.$value."</div></div>";
						$i++;
					}
					break;
			case 11://解析json二维数组
					$i=0;
					echo "<p>Json解析输出</p>";
					echo '<div style="clear:both;line-height:30px;"><div style="float:left;width:100px;height:30px;">【序号】</div><div style="float:left;width:100px;height:30px;">数组键名</div><div style="float:left;width:80px;height:30px;text-align:center;"> 〓〉 </div><div style="float:left;width:300px;height:30px;margin:0 0 0 20px;">数组键值</div></div>';
					foreach($isjson as $key => $value)
					{
						if(is_array($value))
						{
							echo '<div style="clear:both;line-height:30px;"><div style="float:left;width:100px;height:30px;">【'.$i.'】</div><div style="float:left;width:100px;height:30px;">[ '.$key.' ]</div><div style="float:left;width:80px;height:30px;text-align:center;"> 〓〉 </div><div style="float:left;width:300px;height:30px;margin:0 0 0 20px;">↓【子数组】</div></div>';
							
							foreach($value as $keys => $values)
							{
								echo '<div style="clear:both;line-height:30px;color:#fff;"><div style="float:left;width:100px;height:30px;">【'.$key.'】</div><div style="float:left;width:100px;height:30px;">[ '.$keys.' ]</div><div style="float:left;width:80px;height:30px;text-align:center;"> { : } </div><div style="float:left;width:300px;height:30px;margin:0 0 0 20px;">[ '.$values.' ]</div></div>';
							}
						}
						else
						{
							echo '<div style="clear:both;line-height:30px;"><div style="float:left;width:100px;height:30px;">【'.$i.'】</div><div style="float:left;width:100px;height:30px;">"'.$key.'"</div><div style="float:left;width:80px;height:30px;text-align:center;"> 〓〉 </div><div style="float:left;width:300px;height:30px;margin:0 0 0 20px;">"'.$value.'"</div></div>';
						}
						
						$i++;
					}
					break;
			default :
					"<p>数据原型解析输出（Var_dump）</p>";
					var_dump($info);
					break;
		}
		echo "</p></div>";
		echo '<HR style="FILTER: progid:DXImageTransform.Microsoft.Shadow(color:#987cb9,direction:145,strength:15);margin:25px auto 0;" width="98%" color=#ff461f SIZE=5>';
		//echo self::$htmlfooter;
	}
	/**
	 * 返回数组的维度
	 * @param  [type] $arr [description]
	 * @return [type]      [description]
	 */
	static function aL($arr,&$al,$level=0){
			if(is_array($arr)){
				$level++;
				$al[] = $level;
				foreach($arr as $v){
					error_info::aL($v,$al,$level);
				}
			}
	}
	static function arrayLevel($arr)
	{
		$al = array(0);
		error_info::aL($arr,$al);
		$maxlev=max($al);
		return $maxlev;
	}
	/*判断输出是否为json数据格式*/
	static function analyJson($json_str) {
		$oldjson=$json_str;
		$json_str = str_replace('\\', '', $json_str);
		$out_arr = array();
		preg_match('/\{.*\}/', $json_str, $out_arr);
		if (!empty($out_arr)) 
		{
			//print_r($oldjson);
			$result = json_decode($oldjson, TRUE);
		} 
		else 
		{
			return FALSE;
		}
		return $result;
	}
}
?>