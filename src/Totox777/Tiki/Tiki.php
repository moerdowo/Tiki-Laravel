<?php namespace Totox777\Tiki;

class Tiki {

    private $url;
    private $url2;

    public function __construct($url, $url2)
    {
        $this->url = $url;
        $this->url2 = $url2;
    }

    function CariKata($s, $keyword1, $keyword2){
      $l1=strlen($keyword1);
      $x1=strpos($s, $keyword1);
      $x2=strpos($s, $keyword2, $x1+$l1); 
      $l=$x2-($x1+$l1);
      return substr($s, $x1+$l1, $l); 
    }

    function get_string_between($string, $start, $end){
        $string = " ".$string;
        $ini = strpos($string,$start);
        if ($ini == 0) return "";
        $ini += strlen($start);
        $len = strpos($string,$end,$ini) - $ini;
        return substr($string,$ini,$len);
    }

    function getCost($from, $to,$weight){
       
        $url_1 = $this->url;
        $c = curl_init();
        curl_setopt($c, CURLOPT_AUTOREFERER, 1);
        curl_setopt($c, CURLOPT_HTTPGET, 1);
        curl_setopt($c, CURLINFO_HEADER_OUT,1);
        curl_setopt($c, CURLOPT_VERBOSE, 1); 
        curl_setopt($c, CURLOPT_HEADER, 1); 
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($c, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); 
        curl_setopt($c, CURLOPT_URL, $url_1);
        $hasil_1 = curl_exec($c);
        curl_close($c);

        $cookie = $this->CariKata($hasil_1,'PHPSESSID=',';');

        $postdata = array(
          "get_des" => $from,
          "get_ori" => $to,
          "get_wg" => $weight,
          "submit" => "Check"
        );

        $url_2 = $this->url2;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_URL, $url_2);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_COOKIE, "PHPSESSID=$cookie;"); 
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        $hasil_2 = curl_exec($ch);
        curl_close($ch);

        $hasil_2 = preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i",'<$1$2>', $hasil_2);

        $start_tag = '<td>';
        $end_tag = '</td>';

        if (preg_match_all('#<td>([^<]*)</td>#Usi', $hasil_2, $matches)) {
            $awal =  $matches[0];
            $exclude = array('<td>', '</td>');
            $awal = str_ireplace($exclude, '', $awal);
            array_shift($awal);
            //return $awal;

            $arraykirim = array();

            for($i=0;$i<count($awal);$i+=2){
                $price = preg_replace("/([^0-9\\.])/i", "", $awal[$i+1]);
                $xzr = array("layanan"=>$awal[$i],"harga"=>$price);
                array_push($arraykirim, $xzr);
            }

            return $arraykirim;

        }
        else{
            return null;
        }

       
    }

}