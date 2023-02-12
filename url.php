<?
	error_reporting (E_ALL ^ E_NOTICE); 
    function encode($string){
        return base64_encode($string);
    }

    function decode($string){
        return base64_decode($string);
    }

    function CR64($string){
        return base64_encode($string);
    }
    
    function DR64($string){
        $DsK121m = base64_decode($string);
        $param = preg_replace('/\\x13\\x00*$/', '', $DsK121m);
        parse_str($param,$svar);
        return $svar;
    }

    function getParam($string){
        $param = preg_replace('/\\x13\\x00*$/', '', $string);
        parse_str($param,$svar);
        return $svar;
    }

    function sTawon(){
        $tawon = md5(date('Y-m-d H:i:s'));
        return $tawon;
    }

    function set_pager_cr($key){
        $key = env('PAGER_KEY','PB_SUSU');
        return $key;
    }

    function get_rnd_iv($iv_len){
        $iv = '';
        while ($iv_len-- > 0) {
            $iv .= chr(mt_rand() & 0xff);
        }
        return $iv;
    }

    function bcrypt_enc($plain_text, $password, $iv_len = 16){
        $plain_text .= "\x13";
        $n = strlen($plain_text);
        if ($n % 16) $plain_text .= str_repeat("\0", 16 - ($n % 16));
        $i = 0;
        $enc_text = BaseController::get_rnd_iv($iv_len);
        $iv = substr($password ^ $enc_text, 0, 512);
        while ($i < $n) {
            $block = substr($plain_text, $i, 16) ^ pack('H*', md5($iv));
            $enc_text .= $block;
            $iv = substr($block . $iv, 0, 512) ^ $password;
            $i += 16;
        }
        $hasil=base64_encode($enc_text);
        return str_replace('+', '@', $hasil);
    }

    function bcrypt_dec($string, $password, $iv_len = 16){
        $vars = explode("?",$string);
        if(count($vars)>1){
            $enc_text = str_replace('@', '+', $vars[1]);
            $enc_text = base64_decode($enc_text);
            $n = strlen($enc_text);
            $i = $iv_len;
            $plain_text = '';
            $iv = substr($password ^ substr($enc_text, 0, $iv_len), 0, 512);
            while ($i < $n) {
                $block = substr($enc_text, $i, 16);
                $plain_text .= $block ^ pack('H*', md5($iv));
                $iv = substr($block . $iv, 0, 512) ^ $password;
                $i += 16;
            }
            $param = preg_replace('/\\x13\\x00*$/', '', $plain_text);
            parse_str($param,$var);
        }
        else{
            $var=NULL;
        }
        return $var;
    }

    function bcrypt_dec_param($string, $password, $iv_len = 16){
      $vars = $string;
      $enc_text = str_replace('@', '+', $vars);
      $enc_text = base64_decode($enc_text);
      $n = strlen($enc_text);
      $i = $iv_len;
      $plain_text = '';
      $iv = substr($password ^ substr($enc_text, 0, $iv_len), 0, 512);
      while ($i < $n) {
          $block = substr($enc_text, $i, 16);
          $plain_text .= $block ^ pack('H*', md5($iv));
          $iv = substr($block . $iv, 0, 512) ^ $password;
          $i += 16;
      }
      $param = preg_replace('/\\x13\\x00*$/', '', $plain_text);
      parse_str($param,$var);
      return $var;
    }

    $password = 'PB_SUSU';
    $iv_len = 16;
    //$rincian_sub_keg_opd = "gXBIiAt3IZtzmcRPuSv/hSJw64IDgRDa0twpRuLnu9rPtYXoFCGpVy7n8wK6KLV5XxawHT5Pq4HxLfLqQ9Ff2QYJWkarfggH9n7fQe6cjd54qBsVJ9HjJv1gjnRK8mFiUt6hKyI4TZCX2y0OGr7QdAgNM5sIHIcnwjICkUGb@xc=";
    //$list_sub_keg_opd = "UXbHepJgR6ck6vqXJIXKtkhdnSBwpDr47ALwFNt7zmLp7oRPu4MHA3soB6eVgXcC8hkzcZTmDS@hmxkCwK3hReMKI8lIP3u3Ckfp@qO4QRne4BWDhoO2Eh/oJwjOlmfHHICgI5kg8A2hr7Jm3Iw6W8o8FO58CgcqwiGwusmzDQU=";
    //$list_opd = "xWxdc2Ynim@ElKzl4HxmM1qandxq6fE2W@BG9Oo77ow8rvsO4vgGiJRsMX2FFG/PrRSWDlYdpUGgrDVxnTpygQ7Cz3PL4eRN40BkrRz7oHeKbXzdDKitUhVdaTZmT8Vo3O4vc2Q/farBvCtAyK6AuQboGp3ZuWpyowBGQsSnBDM=";
    //$b = "app=budget&modul=sub_giat_bl&sdata=anggaran&sview=tampil_skpd&stahun=2022&sdaerah=115&sidunit=0&";
    //$a = "xWxdc2Ynim@ElKzl4HxmM1qandxq6fE2W@BG9Oo77ow8rvsO4vgGiJRsMX2FFG/PrRSWDlYdpUGgrDVxnTpygQ7Cz3PL4eRN40BkrRz7oHeKbXzdDKitUhVdaTZmT8Vo3O4vc2Q/farBvCtAyK6AuQboGp3ZuWpyowBGQsSnBDM=";
    //$ax="?E4Ycj84SQ6QPlLx3Xsq0YAdprfC@3IaGXfYQF7I8j5/Le5NqUpPTtuOiLqxrbNbeiG1sYcfRccwgQDiZIMyXhyfiEimr4AimrGZ5YAZne68yf0p1pHW1QeyO6K/ytgMBFg4y9bWUMr6AFCrmaiToJpZ7vWip92bsKOYWXooNMJY=";
		echo "<form method='POST' action='url.php' id='frm'>";

		$a = $_POST['url'];

    echo "URL<br><textarea id='url' name='url' rows='3' style='width:100%'>".$_POST['url']."</textarea>";
    $hasilnya = "";
    if($_POST['a'] == 'de'){
        $vars = explode("?",$a);
        if(count($vars)>1){
            $enc_text = str_replace('@', '+', $vars[1]);
//            echo $vars[1]."--<br>";die();
            $enc_text = base64_decode($enc_text);
            $n = strlen($enc_text);
            $i = $iv_len;
            $plain_text = '';
            $iv = substr($password ^ substr($enc_text, 0, $iv_len), 0, 512);
            while ($i < $n) {
                $block = substr($enc_text, $i, 16);
                $plain_text .= $block ^ pack('H*', md5($iv));
                $iv = substr($block . $iv, 0, 512) ^ $password;
                $i += 16;
            }
            $param = preg_replace('/\\x13\\x00*$/', '', $plain_text);
            $hasilnya = $param;
//            parse_str($param,$var);
        }else{
            $vars = $a;
              $enc_text = str_replace('@', '+', $vars);
              $enc_text = base64_decode($enc_text);
              $n = strlen($enc_text);
              $i = $iv_len;
              $plain_text = '';
              $iv = substr($password ^ substr($enc_text, 0, $iv_len), 0, 512);
              while ($i < $n) {
                  $block = substr($enc_text, $i, 16);
                  $plain_text .= $block ^ pack('H*', md5($iv));
                  $iv = substr($block . $iv, 0, 512) ^ $password;
                  $i += 16;
              }
              $param = preg_replace('/\\x13\\x00*$/', '', $plain_text);
              parse_str($param,$var);
              $hasilnya = $param;
        }
    }
    function gset_rnd_iv($iv_len){
        $iv = '';
        while ($iv_len-- > 0) {
            $iv .= chr(mt_rand() & 0xff);
        }
        return $iv;
    }

    if($_POST['a'] == 'en'){
            $plain_text = $a;
            $plain_text .= "\x13";
            $n = strlen($plain_text);
            if ($n % 16) $plain_text .= str_repeat("\0", 16 - ($n % 16));
            $i = 0;
            $enc_text = get_rnd_iv($iv_len);
            $iv = substr($password ^ $enc_text, 0, 512);
            while ($i < $n) {
                $block = substr($plain_text, $i, 16) ^ pack('H*', md5($iv));
                $enc_text .= $block;
                $iv = substr($block . $iv, 0, 512) ^ $password;
                $i += 16;
            }
            $hasil=base64_encode($enc_text);
            $hasilnya = $hasil;
        }
			//echo $_POST['a']." of ".$a."<br><hr>";
       // echo md5(date('m:d:Y')."@D3m1T!")."<br>";
    echo "URL<br><textarea id='clear' name='clear' rows='3' style='width:100%'>".$hasilnya."</textarea>";
		echo "<select name='a'><option value='en'>Encode</option><option value='de'>Decode</option></select><br>";
		echo "<input type='submit' value='Submit'>";
		echo "</form>";

?>
<script>

</script>
