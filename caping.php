<?PHP
date_default_timezone_set("Asia/jakarta"); 
$date = new DateTime('now');
$jam = $date->format('H:i ')."WIB";
$hari = $date->format('l, j F Y');
include("logo.php");
include("config.php");
$idchannel = array();
$idnews = array();
$idvideo = array();

function curlget($url,$cookie){
    $ch = curl_init();
    curl_setopt_array($ch,[
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_TIMEOUT => 30,
        CURLOPT_USERAGENT => "Mozilla/5.0 (Linux; Android 6.0; MEIZU_M5 Build/MRA58K; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/44.0.2403.128 Mobile Safari/537.36;CapingNews/5.0.4",
        CURLOPT_COOKIE => $cookie,
        CURLOPT_HTTPHEADER => array("NETWORKSTATE: FouthG")]);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
};

function curlpost($url,$cookie,$data){
    global $m,$r;
    $ch = curl_init();
    curl_setopt_array($ch,[
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_TIMEOUT => 30,
        CURLOPT_USERAGENT => "Mozilla/5.0 (Linux; Android 6.0; MEIZU_M5 Build/MRA58K; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/44.0.2403.128 Mobile Safari/537.36;CapingNews/5.0.4",
        CURLOPT_COOKIE => $cookie,
        CURLOPT_HTTPHEADER => array("Content-Type: application/json","NETWORKSTATE: FouthG"),
        CURLOPT_POSTFIELDS => $data]);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
};

function curlpost2($url,$cookie){
    $ch = curl_init();
    curl_setopt_array($ch,[
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_TIMEOUT => 30,
        CURLOPT_USERAGENT => "Mozilla/5.0 (Linux; Android 6.0; MEIZU_M5 Build/MRA58K; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/44.0.2403.128 Mobile Safari/537.36;CapingNews/5.0.4",
        CURLOPT_COOKIE => $cookie,
        CURLOPT_HTTPHEADER => array("Content-Type: application/json","NETWORKSTATE: FouthG")]);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
};

function login(){
    global $config,$caping,$m,$h,$p,$r;
    system("clear");
    echo $caping;
    echo $h."[★] Login ";
    sleep (1);
    echo $p."•";
    sleep (1);
    echo "•";
    sleep (1);
    echo "•";
    sleep (1);
    echo "•";
    sleep (1);
    echo "•".$r;
    $url1 = "https://ai.caping.co.id/v2/user/login/visitor";
    $url2 = "https://ai.caping.co.id/v2/user/activeccsp";
    $data = json_encode(array("city"=>"Jakarta"));
    foreach($config as $cookie):
        $login1 = curlpost($url1,$cookie,$data);
        $login2 = curlget($url2,$cookie);
        if ($login1 == FALSE):
            exit($m."\n[!] Connection Error\n".$r);
        endif;
        if ($login2 == FALSE):
            exit($m."\n[!] Connection Error\n".$r);
        endif;
    endforeach;
};

function menu(){
    global $caping,$config,$m,$h,$k,$r;
    system("clear");
    echo $caping;
    echo $h."Total Account: ".$k.count($config).$r."\n";
    echo $h."[★]==[".$k."1".$m.".".$h." Claim    ]==[★]   [★]==[".$k."3".$m.".".$h." Cek akun ]==[★]\n";
    echo "[★]==[".$k."2".$m.".".$h." Redeem   ]==[★]   [★]==[".$k."4".$m.". Keluar   ".$h."]==[★]\n".$r;
    pilih_menu();
};

function pilih_menu(){
    global $config,$id,$m,$h,$k,$b,$r;
    echo $h."[?] Pilih ".$k."=> ".$h;
    $pilih = trim(fgets(STDIN));
    if ($pilih == "1"):
        echo $h."\n[★]==============[ ".$k."Absen  Harian".$h." ]==============[★]\n".$r;
        idnews();
        absen();
        echo $h."\n[★]==============[ ".$k."Buka  Diamond".$h." ]==============[★]\n".$r;
        diamon();
        echo $h."\n[★]=============[ ".$k."Buka Notifikasi".$h." ]=============[★]\n".$r;
        notifikasi();
        echo $h."\n[★]==========[ ".$k."Bagikan Link Undangan".$h." ]==========[★]\n".$r;
        idvideo();
        share_code();
        echo $h."\n[★]=============[ ".$k."Bagikan  Konten".$h." ]=============[★]\n".$r;
        share_content();
        echo $h."\n[★]==============[ ".$k."Nonton  Video".$h." ]==============[★]\n".$r;
        video();
        echo $h."\n[★]==============[ ".$k."Baca  Artikel".$h." ]==============[★]\n".$r;
        baca();
        echo $h."[★] Selesai\n".$r;
        echo $h."[!] Kembali Ke Menu Utama [".$k."Enter".$h."]".$r;
        trim(fgets(STDIN));
        menu();
    elseif($pilih == 2):
        pilih_akun();
    elseif($pilih == 3):
        cek_akun();
        echo $h."[!] Kembali Ke Menu Utama [".$k."Enter".$h."]".$r;
        trim(fgets(STDIN));
        menu();
    elseif($pilih == 4):
        exit($m."[!] Keluar\n".$r);
    else:
        echo $m."[!] pilihan tidak ada\n".$r;
        sleep(1);
        pilih_menu();
    endif;
};

function pilih_akun(){
    global $config,$m,$p,$k,$h,$b,$r;
    $url1 = "https://ai.caping.co.id/v2/config/campaign/get";
    $url2 = "https://ai.caping.co.id/v2/user/ccsp/detail";
    $i=0;
    while($i<count($config)):
        $cookie = $config[$i];
        curlpost2($url1,$cookie);
        $detail = curlget($url2,$cookie);
        $uid1 = explode('"uid":',$detail);
        $uid2 = explode(',', $uid1[1]);
        $money1 = explode('"money":',$detail);
        $money2 = explode(',', $money1[1]);
        $i++;
        echo $h."[★]=[".$k.$i.$m.".".$h." User: ".$k.$uid2[0].$b."   ││   ".$h." Money: ".$p."Rp ".$money2[0].$h."\n".$r;
        sleep(0);
    endwhile;
    echo $h."[?] Pilih Akun ".$k."=> ".$h;
    $pilih = trim(fgets(STDIN));
    $akun = $pilih-=1;
    produk($akun);
};

function produk($akun){
    global $config,$m,$h,$k,$p,$r;
    $cookie = $config[$akun];
    $url = "https://ai.caping.co.id/v2/product/list?offset=0&limit=2147483647";
    $produk = curlpost2($url,$cookie);
    $total1 = explode('"total":',$produk);
    $total2 = explode(',',$total1[1]);
    $current1 = explode('"current":',$produk);
    $current2 = explode(',',$current1[1]);
    $harga1 = explode('"original_price":',$produk);
    $harga2 = explode(',',$harga1[1]);
    $nama1 = explode('"name":"',$produk);
    $nama2 = explode('",',$nama1[1]);
    echo $h."[★] ".$k.$nama2[0]."\n";
    echo $h."[★] Harga: ".$p."Rp ".$harga2[0]."\n";
    echo $h."[★] Stok : ".$h.$current2[0].$p."/".$h.$total2[0].$r."\n";
    if ($current2[0] == 1):
        exit($m."[!] Stok voucher kosong\n".$r);
    else:
        echo $h."[?] No Hp: ".$p."+62";
        $no = trim(fgets(STDIN));
        redeem($no,$akun);
    endif;
};

function redeem($no,$akun){
    global $config;
    $url = "https://ai.caping.co.id/v2/product/order/create";
    $cookie = $config[$akun];
    $u1 = explode('u=',$cookie);
    $u2 = explode(';', $u1[1]);
    $u = $u2[0];
    $data = json_encode(array("mobile"=>$no,"productId"=>"1","uid"=>$u));
    echo $data."\n";
    $redeem = curlpost($url,$cookie,$data);
    #$get1 = explode('"message":"',$redeem);
    #$get2 = explode('"', $get1[1]);
    echo $redeem."\n";
};

function idvideo(){
    global $config,$idvideo,$idchannel;
    $url = "https://ai.caping.co.id/v2/news/getNewsList";
    $idv = array(1);
    $i=0;
    while($i<count($config)):
        $id2 = array_values(array_unique($idv));
        array_shift($id2);
        $cookie = $config[$i];
        if (count($id2) == 5):
            $i=count($config);
        else:
            $x=0;
            $data = json_encode(array("articleType"=>512,"channelId"=>$idchannel[$i],"page"=>1));
            $conten = curlpost($url,$cookie,$data);
            $jum = count(json_decode($conten ,true)["data"]["list"]);
            while($x<$jum):
                $id2 = array_values(array_unique($idv));
                array_shift($id2);
                if(count($id2) == 5):
                    $x=$jum;
                else:
                    $x++;
                    $get1 = explode('"NewsId":', $conten);
                    $get2 = explode(',', $get1[$x]);
                    array_push($idv,$get2[0]);
                endif;
            endwhile;
            $i++;
        endif;
    endwhile;
    $id2 = array_values(array_unique($idv));
    array_shift($id2);
    $a=0;
    while($a<count($id2)):
        array_push($idvideo,$id2[$a]);
        $a++;
    endwhile;
};

function idnews(){
    global $config,$idnews,$idchannel;
    $url = "https://ai.caping.co.id/v2/news/getNewsList";
    $data = json_encode(array("articleType"=>1,"channelId"=>0,"count"=>10,"isUpQuery"=>0,"lastId"=>0,"page"=>1,"publishdate"=>""));
    $idn1 = array(1);
    $idc1 = array();
    $i=0;
    while($i<10):
        $idn2 = array_values(array_unique($idn1));
        array_shift($idn2);
        if (count($idn2) == 20):
            $i=10;
        else:
            foreach($config as $cookie):
                $x=0;
                $conten = curlpost($url,$cookie,$data);
                $jum = count(json_decode($conten ,true)["data"]["list"]);
                while($x<$jum):
                    $idn2 = array_values(array_unique($idn1));
                    array_shift($idn2);
                    if (count($idn2) == 20):
                        $x=$jum;
                    else:
                        $x++;
                        $at1 = explode('"ArticleType":', $conten);
                        $at2 = explode(',', $at1[$x]);
                        if ($at2[0] == 1):
                            $get1 = explode('"NewsId":', $conten);
                            $get2 = explode(',', $get1[$x]);
                            $get3 = explode('"ChannelId":', $conten);
                            $get4 = explode(',', $get3[$x]);
                            array_push($idn1,$get2[0]);
                            array_push($idc1,$get4[0]);
                        else:
                            sleep(1);
                        endif;
                    endif;
                endwhile;
            endforeach;
            $i++;
        endif;
    endwhile;
    $idn2 = array_values(array_unique($idn1));
    array_shift($idn2);
    $a=0;
    while($a<count($idn2)):
        array_push($idnews,$idn2[$a]);
        $a++;
    endwhile;
    $idc2 = array_values(array_unique(array_filter($idc1)));
    $a=0;
    while($a<count($idc2)):
        array_push($idchannel,$idc2[$a]);
        $a++;
    endwhile;
};

function cek_akun(){
    global $config,$m,$k,$h,$b,$p,$r;
    $url = "https://ai.caping.co.id/v2/user/ccsp/detail";
    foreach($config as $cookie):
        $detail = curlget($url,$cookie);
        if ($detail == FALSE):
            echo $m."[!] Connection Error\n".$r;
        else:
            $uid1 = explode('"uid":',$detail);
            $uid2 = explode(',', $uid1[1]);
            $coin1 = explode('"coin":',$detail);
            $coin2 = explode(',', $coin1[1]);
            $money1 = explode('"money":',$detail);
            $money2 = explode(',', $money1[1]);
            echo $h."[★] User:".$k.$uid2[0].$b." ││".$h." Coin:".$p.$coin2[0].$b." ││".$h." Money: ".$p."Rp ".$money2[0]."\n".$r;
            sleep(2);
        endif;
    endforeach;
    
};

function absen(){
    global $config,$m,$h,$k,$b,$r;
    $url1 = "https://ai.caping.co.id/v2/event/signin";
    $url2 = "https://ai.caping.co.id/v2/user/ccsp/detail";
    $i=0;
    foreach($config as $cookie):
        $absen = curlget($url1,$cookie);
        if ($absen == FALSE):
            echo $m."[!] Connection Error\n".$r;
        else:
            $detail = curlget($url2, $cookie);
            if ($detail == FALSE):
                echo $m."[!] Connection Error\n".$r;
            else:
                $get1 = explode('"get_coin":',$absen);
                $get2 = explode(',', $get1[1]);
                $nama1 = explode('"uid":', $detail);
                $nama2 = explode(',', $nama1[1]);
                $coin1 = explode('"coin":', $detail);
                $coin2 = explode(',', $coin1[1]);
                echo $h."[★] User: ".$k.$nama2[0];
                if ($get2[0]>0):
                    echo $b." ││".$h." Claim ".$k.$get2[0].$h." Coin ".$b."││".$h." Coin: ".$k.$coin2[0].$r."\n";
                else:
                    echo $b." ││".$m." Sudah Absen   ".$b."││".$h." Coin: ".$k.$coin2[0].$r."\n";
                endif;
                sleep(2);
            endif;
        endif;
    endforeach;
};

function diamon(){
    global $config,$m,$h,$k,$b,$r;
    $url1 = "https://ai.caping.co.id/v2/event/random";
    $url2 = "https://ai.caping.co.id/v2/user/ccsp/detail";
    $i=0;
    foreach($config as $cookie):
        $diamon = curlget($url1,$cookie);
        if ($diamon == FALSE):
            echo $m."[!] Connection Error\n".$r;
        else:
            $detail = curlget($url2, $cookie);
            if ($detail == FALSE):
                echo $m."[!] Connection Error\n".$r;
            else:
                $get1 = explode('"get_coin":',$diamon);
                $get2 = explode(',', $get1[1]);
                $nama1 = explode('"uid":',$detail);
                $nama2 = explode(',', $nama1[1]);
                $coin1 = explode('"coin":', $detail);
                $coin2 = explode(',', $coin1[1]);
                echo $h."[★] User:".$k.$nama2[0];
                if ($get2[0] > 9):
                    echo $b." ││".$h." Mendapat ".$k.$get2[0].$h." Coin ".$b."││".$h." Coin: ".$k.$coin2[0].$r."\n";
                elseif($get2[0] > 0):
                    echo $b." ││".$h." Mendapat ".$k.$get2[0].$h." Coin  ".$b."││".$h." Coin: ".$k.$coin2[0].$r."\n";
                else:
                    echo $b." ││".$m." Sudah Membuka 💎 ".$b."││".$h." Coin: ".$k.$coin2[0].$r."\n";
                endif;
                sleep(2);
            endif;
        endif;
    endforeach;
};

function cek_misi($url){
    global $config,$m,$h,$c,$b,$p,$r;
    $url1 = "https://ai.caping.co.id/v2/user/ccsp/detail";
    foreach($config as $cookie):
        $misi = curlget($url,$cookie);
        if ($misi == FALSE):
            echo $m."[!] Connection Error\n".$r;
        else:
            sleep(2);
            $detail = curlget($url1, $cookie);
            if ($detail == FALSE):
                echo $m."[!] Connection Error\n".$r;
            else:
                $uid1 = explode('"uid":', $detail);
                $uid2 = explode(',', $uid1[1]);
                $coin1 = explode('"coin":', $detail);
                $coin2 = explode(',', $coin1[1]);
                echo $h."[★] User: ".$c.$uid2[0].$b." ││".$h."  Success  ".$b."││".$h." [★] Coin: ".$p.$coin2[0].$r."\n";
                sleep(3);
            endif;
        endif;
    endforeach;
};

function notifikasi(){
    $x=0;
    while($x<5):
        $url = "https://ai.caping.co.id/v2/event/share/click/push";
        cek_misi($url);
        loading();
        $x++;
    endwhile;
}

function share_code(){
    $x=0;
    while($x<5):
        $url = "https://ai.caping.co.id/v2/event/share/code";
        cek_misi($url);
        loading();
        $x++;
    endwhile;
}

function share_content(){
    global $idnews;
    $x=0;
    while($x<5):
        $url = "https://ai.caping.co.id/v2/event/share/news/".$idnews[$x];
        cek_misi($url);
        loading();
        $x++;
    endwhile;
}

function video(){
    global $idvideo;
    $x=0;
    while($x<5):
        $url = "https://ai.caping.co.id/v2/event/video/view/".$idvideo[$x];
        cek_misi($url);
        loading();
        $x++;
    endwhile;
}

function baca(){
    global $idnews;
    $x=0;
    while($x<20):
        $url = "https://ai.caping.co.id/v2/event/news/view/".$idnews[$x];
        cek_misi($url);
        loading();
        $x++;
    endwhile;
}

function loading(){
    global $config,$g,$y,$h,$k,$r;
    $i = count($config);
    if($i == 1):
        $g=6.4;
        $y=32;
    elseif($i == 2):
        $g=5.4;
        $y=27;
    elseif($i == 3):
        $g=4.4;
        $y=22;
    elseif($i == 4):
        $g=3.4;
        $y=17;
    elseif($i == 5):
        $g=2.4;
        $y=12;
    elseif($i == 6):
        $g=1.4;
        $y=7;
    else:
        $g=0.4;
        $y=2;
    endif;
    echo $h."[★] Sleep [".$k.$y.$h."] Detik ";
    sleep ($g);
    echo "•";
    sleep ($g);
    echo "•";
    sleep ($g);
    echo "•";
    sleep ($g);
    echo "•";
    sleep ($g);
    echo "•\n".$r;
};
login();
menu();
?>