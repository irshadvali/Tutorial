<?php
    class Common
    {
        function executeCurl($url, $isRaw = false, $tm = false, $postData = false, $fromWhere = false, $authData = false, $sslCurl = false)
        {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            if(!empty($postData))
            {
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            }

            if(!empty($tm))
            {
                curl_setopt($ch, CURLOPT_TIMEOUT, $tm);
            }

            if(!empty($authData))
            {
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                curl_setopt($ch, CURLOPT_USERPWD, $authData['user'] . ":" . $authData['pwd']);
            }

            if($sslCurl)
            {
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            }

            $result = curl_exec($ch);
            curl_close($ch);

            if(empty($isRaw))
            {
                $result = json_decode($result, 1);
            }

            return $result;
        }

		public function clearParam($d, $isPost = false)
		{
			if(count($d))
			{
				foreach($d as $k => $v)
				{
          $v = strip_tags($v);
        	if($isPost)
					{
						$_POST[$k] = str_replace('-',' ',$v);
					}
					else
					{
						$_GET[$k] = str_replace('-',' ',$v);
					}
				}
			}
		}

    function IND_Money_Decimal($money)
        {
            $afterPoint='';
            $before = '';
            $money = number_format($money,2,'.','');
            if(strpos($money,".") > 0)
                $value = explode('.',$money);

            $afterPoint = $value[1];
            $before = $value[0];
            $len = strlen($before);
            $m = '';
            $before = strrev($before);
            for($i=0;$i<$len;$i++)
            {
                if(( $i==3 || ($i>3 && ($i-1)%2==0) )&& $i != $len)
                {
                    $m .=',';
                }
                $m .=$before[$i];
            }
            $start = strrev($m);
            //if($value[1] != 0 || $value[1] != '0')
            $final = $start.'.'.$value[1];
          //  else
          //  $final = $start;

            return $final;
        }


function decimal_to_words($x)
{
$x = str_replace(',','',$x);
$pos = strpos((string)$x, ".");
if ($pos !== false) { $decimalpart= substr($x, $pos+1, 2); $x = substr($x,0,$pos); }
$tmp_str_rtn = $this->number_to_words($x);

if($decimalpart!=0 || $decimalpart!='0')
{
if(!empty($decimalpart))
$tmp_str_rtn .= ' and '  . $this->decimalWord($decimalpart) . ' paise';
}
else{
  if(!empty($decimalpart))
  $tmp_str_rtn;
}
return   $tmp_str_rtn;
}

function decimalWord($num)
{
  $decimal = array("zero", "one", "two", "three", "four", "five", "six", "seven", "eight", "nine");

  if($num > 10)
  {
    $last = intval($num)%10;
    $first = intval($num/10);
    $word = $decimal[$first].' '.$decimal[$last];
  }
  else
  {
    $first = $num;
    $word = $decimal[$first];
  }

  return $word;
}

function number_to_words($x)
{
$nwords = array(  "", "one", "two", "three", "four", "five", "six",
     "seven", "eight", "nine", "ten", "eleven", "twelve", "thirteen",
     "fourteen", "fifteen", "sixteen", "seventeen", "eighteen",
   "nineteen", "twenty", 30 => "thirty", 40 => "fourty",
              50 => "fifty", 60 => "sixty", 70 => "seventy", 80 => "eigthy",
              90 => "ninety" );

if(!is_numeric($x))
{
  $w = '#';
}else if(fmod($x, 1) != 0)
{
  $w = '#';
}else{
  if($x < 0)
  {
      $w = 'minus ';
      $x = -$x;
  }else{
      $w = '';
  }
  if($x < 21)
  {
      $w .= $nwords[$x];
  }else if($x < 100)
  {
      $w .= $nwords[10 * floor($x/10)];
      $r = fmod($x, 10);
      if($r > 0)
      {
          $w .= ' '. $nwords[$r];
      }
  } else if($x < 1000)
  {

      $w .= $nwords[floor($x/100)] .' hundred';
      $r = fmod($x, 100);
      if($r > 0)
      {
          $w .= ' '. $this->number_to_words($r);
      }
  } else if($x < 100000)
  {
   $w .= $this->number_to_words(floor($x/1000)) .' thousand';
      $r = fmod($x, 1000);
      if($r > 0)
      {
          $w .= ' ';
          if($r < 100)
          {
              $w .= ' ';
          }
          $w .= $this->number_to_words($r);
      }
  } else {
      $w .= $this->number_to_words(floor($x/100000)) .' lacs';
      $r = fmod($x, 100000);
      if($r > 0)
      {
          $w .= ' ';
          if($r < 100)
          {
              $word .= ' ';
          }
          $w .= $this->number_to_words($r);
      }
  }
}
return $w;
}


		public function compare_dates($date1, $date2, $bsplit = false)
		{
			$difftime = ceil((strtotime($date1) - strtotime($date2))/(86400));

			$showdate = $date1;
			if($bsplit)
			{
				$ourdate = explode(' ', $date1);
				$newdate = explode('-',$ourdate[0]);
				$newtime = explode(':',$ourdate[1]);
				$date1 = mktime(intval($newtime[0]), intval($newtime[1]), intval($newtime[2]), intval($newdate[1]), intval($newdate[2]), intval($newdate[0]));
			}

			if($date2)
			{
				$ourdate1 = explode(' ', $date2);
				$newdate1 = explode('-',$ourdate1[0]);
				$newtime1 = explode(':',$ourdate1[1]);
				$date2 = mktime(intval($newtime1[0]), intval($newtime1[1]), intval($newtime1[2]), intval($newdate1[1]), intval($newdate1[2]), intval($newdate1[0]));
			}

			if($ourdate[0] == $ourdate1[0])
			{
				return 'Today';
			}
			else if($difftime == 1)
			{
				return 'Tomorrow';
			}
			else
			{
				return date("dS M", $date1);
			}

			//echo $date1.' -- '.$date2;die;
			//$date2 = time();
			$blocks = array
			(
				array('name'=>'month','amount'  => 60*60*24*31),
				array('name'=>'week','amount'   => 60*60*24*7 ),
				array('name'=>'day','amount'    => 60*60*24   ),
				array('name'=>'hour','amount'   => 60*60      ),
				array('name'=>'minute','amount' => 60         ),
				array('name'=>'second','amount' => 1          )
			);

			$diff   = abs($date1-$date2);
			$levels = 1;
			$current_level = 1;
			$result = array();
			$check  = 0;
			$i=0;

			unset($result);
			foreach($blocks as $block)
			{
				if ($current_level > $levels)
				{
					break;
				}
				if ($diff/$block['amount'] >= 1)
				{
					$amount = floor($diff/$block['amount']);
					if ($amount>1) {$plural='s';} else {$plural='';}
					if(($block['name']=='hour' || $block['name']=='day') && $i==0)
					{
						if($block['name']=='hour')
							$checkdate = date("d-m-Y", strtotime("-".$amount." hours"));
						else
							$checkdate = date("d-m-Y", strtotime("-".$amount." days"));

						if($checkdate == date("d-m-Y", strtotime("-1 days")))
						{
							$check = 2;
						}
						if($checkdate == date("d-m-Y", strtotime("-0 days")) && $amount>8)
						{
							$check = 1;
						}
					}

					if($block['name']=='week' && $i==0)
					{
						if($amount==4)
						{
							$check=3;
						}
					}
					$result[] = $amount.' '.$block['name'].$plural;
					$diff -= $amount*$block['amount'];
					$current_level++;
					$i++;
				}

				if($ourdate[0] == date("Y-m-d", strtotime("-1 days")))
				{
					$check = 2;
				}

				if($ourdate[0] == date("Y-m-d", strtotime("+1 days")))
				{
					$check = 4;
				}
			}

			switch ($check)
			{
				case 1:
					return 'Today';
				break;
				case 2:
					return 'Yesterday';
				break;
				case 3:
					$showdate = date('jS M',$date1);
					return $showdate;
				break;
				case 4:
					return 'Tomorrow';
				break;
				default:
					$resultstr = implode(' ',$result);
					if(($amount <= 1 && stristr($resultstr, 'hour')) || stristr($resultstr, 'minute') || stristr($resultstr, 'second'))
					{
						return 'Now';
					}
					else
					{
						if(stristr($resultstr,'hour') || stristr($resultstr,'minute') || stristr($resultstr,'second'))
							return ucwords(strtolower(implode(' ',$result)));
						else
							$showdate = date('jS M',$date1);
					}
					return $showdate;
				break;
			}
		}

		public function INR_format($money)
		{
			$len = strlen($money);
			$m = '';
			$money = strrev($money);
			for($i=0;$i<$len;$i++)
			{
				if(( $i==3 || ($i>3 && ($i-1)%2==0) )&& $i != $len)
				{
					$m .=',';
				}
				$m .=$money[$i];
			}

			return strrev($m);
		}

    public function getTot($val)
    {
      $totVal = round(floatval($val),2) + round((floatval($val)*0.14),2) + round((floatval($val)*.005),2) + round((floatval($val)*.005),2);
      return floatval($totVal);
    }

    public function getTotWithTax($val,$ser,$swach,$krishi)
    {
      $withTax =  round(floatval($val),2) + round(floatval($ser),2) + round(floatval($swach),2) + round(floatval($krishi),2);
      return floatval($withTax);
    }

    public function getSerTax($val)
    {
      //$tempVal =floatval($val)*0.14;
      $withTax = round((floatval($val)*0.14),2);
      return $withTax;
    }

    public function getSwachhTax($val)
    {
      //$tempVal = floatval($val)*0.005;
      $withTax = round((floatval($val)*0.005),2);
      return $withTax;
    }

    public function getKrishiTax($val)
    {
    //  $tempVal = floatval($val)*0.005;
      $withTax = round((floatval($val)*0.005),2);
      return $withTax;
    }

    public function generateId()
		{
  			$cdt = date('Ymd');
  			$mcrTime = microtime();
  			$mcrTime = explode(' ', $mcrTime);

  			if(!empty($mcrTime[1]))
  			{
  				unset($mcrTime[1]);
  			}

  			$mcrTime = $mcrTime[0];

  			$mcrTime = explode('.', $mcrTime);
  			if(!empty($mcrTime[0]))
  			{
  				unset($mcrTime[0]);
  			}

  			if(!empty($mcrTime[1]))
  			{
  				$mcrTime = $mcrTime[1];
  			}

  			if(!empty($mcrTime))
  			{
  				return $cdt.$mcrTime;
  			}
  			else
  			{
  				$curdate = date('YmdHis');
  				$rNo = mt_rand(11, 99);

  				$genId = $rNo . $curdate;
  				return $genId;
  			}
		}
            public function getErrorMsgs($langCode, $action, $errMsg) {
                global $db;
                include_once INCLUDES . 'common/db.class.msi.obj.php';
                $db = new DB($db['4tigo']);

                $sql = "SELECT * FROM tbl_errmsg_master WHERE lang_code=$langCode AND action = '" . $action . "' AND error_en_msg='" . $errMsg . "' AND active_flag=1";
                $res = $db->query($sql);
                if($res) {
                    if($db->numRows($res)>0) {
                        $row = $db->fetchData($res);
                        return $row['error_msg'];
                    }
                }
                return "";
            }

}
?>
