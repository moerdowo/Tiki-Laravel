Laravel-4-TIKI [http://www.tiki-online.com]
====================

Laravel 4 ongkir tiki, curl based

------------

add this line to your composer.json

    "totox777/tiki": "dev-master"
    
and then, Run :

`composer update` to pull down the latest version.

add this line to your app.php provider array:

    'Totox777\Tiki\TikiServiceProvider',
    
and add this line to app.php aliases array:

    'Tiki' => 'Totox777\Tiki\Facades\Profiler',
    



Sample Usage:

    $xxx = Tiki::getCost("denpasar", "bandung",1);
    if($xxx!=null){
        foreach ($xxx as $hasil)
        {
            echo 'Layanan: ' . $hasil['layanan'] . ', dengan harga : Rp. ' . $hasil['harga'] . ',- <br />';
        }
    }
    else{
        echo "Tidak ditemukan jalur pengiriman, silahkan coba kota terdekat";
    }
