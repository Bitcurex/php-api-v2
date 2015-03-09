<?
//sprawdza ile otrzymamy za podan� liczb� btc i ostatni� cen� po jakiej zostanie zrealizowana sprzeda�.
require 'bitcurex.php';

$apiKey='';
$secretKey='';

$b=new Bitcurex($apiKey,$secretKey);

$data=$b->getAllOffers();

$volume=20;//liczba btc do sprzedania


$p=0;//otrzymana suma
$v=0;
$lastPrice=0;
if($data->status=='ok'){
    foreach($data->data as $row){//iterujemy bo wszystkich wystawionych ofertach
        if($row->type=='bid'){//sprawdzamy czy tranzakcja jest typu bid
            if($row->volume<=$volume-$v)$h=$row->volume;//je�eli ilo�� btc w tranzakcji jest mniejsza od liczy jaka jeszcze nam zosta�a 
            else $h=$volume-$v;//realizujemy tylko cz�� tranzakcji jaka nam zosta�a
                $p+=$row->limit*$h;//obliczamy cen� za zrealizowanie tej tranzakcji
                $v+=$h;//zwiekszamy ju� zrealizowan� liczbe btc
                $lastPrice=$row->limit;//zapis ostatnio u�ytej ceny
                if($v==$volume)break;//dotarli�my do tranzakcji w kt�rej sprzedali�my ju� wszystkie btc
        }
    }
    echo 'Price: '.$p.' Volume: '.$v.' Last price: '.$lastPrice;
}

?>