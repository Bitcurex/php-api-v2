<?
//pobranie podstawowych informacji o stanie gie�dy
require 'bitcurex.php';

$b = new Bitcurex();

$ticker = $b->ticker('pln');

echo'Best ask:'.$ticker->best_ask_h.' best bid:'.$ticker->best_bid_h;

?>