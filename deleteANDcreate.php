<?
//usuwanie tranzakcji typu ask o limicie wiekszym od zadanegoi tworzenie tranzakcji o nowym limicie
require 'bitcurex.php';

$apiKey='';
$secretKey='';

$b=new Bitcurex($apiKey,$secretKey);

$data=$b->getUserOffers('pln');

$limit=2000;//o wi�kszym limicie zamykamy
$nLimit=2000;//nowy limit

$v=0;
if($data->status=='ok'){
    foreach($data->data as $row){//iterujemy po wszystkich tranzakcjach
        if($row->type=='ask' && $row->limit>=$limit){//sprawdzamy czy type=ask i czy limit jest wi�kszy od zadanego
            $r=$b->deleteOffer($row->id);//usuwamy tranzakcje o zadanym it
            if($r->status=='ok'){//udana tranzakcja
                echo'Close transaction id:'.$row->id.'<br/>';
                 $v+=$row->volume;//dodajemy liczbe uwolnionych btc
            }
            else echo'Error id:'.$row->id.'<br/>';
        }
    }
    $r=$b->createOffer('pln',$nLimit,$v,'ask');//tworzymy now� ofert� o nowym limicie i liczbie btc takiej jak� uda�o nam si� zwolni�
    if($r->status=='ok')echo'New transaction limit:'.$nLimit.' volume:'.$v.' <br/>';//udane utworzenie tranzakcji
    else echo'error';
}

?>