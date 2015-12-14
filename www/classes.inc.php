<?php
Class Player{
 private $turn;
 public function __construct($order = false){
     $this->turn = $order;
 }
 public function get_turn(){
     return $this->turn;
 }
 public function switch_turn(){
     $this->turn = ! $this->turn;
 }
 public function make_turn($param) {
     echo 'Make turn';
     $this->switch_turn();
 }
 public function __toString (){
     return 'Player';
 }
}
Class Gamefield{
 private $rowSize;
 private $fieldSize;
 private $cells;
 private $player1;
 private $player2;

 public function __construct($size = 3){
     $this->fieldSize = $size;
     if ($this->fieldSize < 3) $this->fieldSize = 3; 
     switch ($this->fieldSize){
         case 3:
             $this->rowSize = 3;
             break;
         case 4:
             $this->rowSize = 3;
             break;
         case 5:
             $this->rowSize = 4;
             break;
         case 6:
             $this->rowSize = 4;
             break;
         case 7:
             $this->rowSize = 4;
             break;
         case 8:
             $this->rowSize = 5;
             break;
         case 9:
             $this->rowSize = 5;
             break;
         case 10:
             $this->rowSize = 5;
             break;
         default:
             $this->fieldSize = 10;
             $this->rowSize = 5;
             break;
     }
     $this->cells = array();
     for ($i=0;$i<$size*$size;$i++){
         $this->cells[$i]=1;
     }
     $this->player1 = new Player(rand(0, 1));
     $this->player2 = new Player(1-$this->player1->get_turn());
 }
 public function getRowSize(){
     return $this->rowSize;
 }
 public function getCells(){
     return $this->cells;
 }
 public function getFieldSize(){
     return $this->fieldSize;
 }
 public function getActivePlayer(){
     if ($this->player1->get_turn()){
         echo 'Player 1'.'</br>';
         return $this->player1;
     }else if ($this->player2->get_turn()){
         echo 'Player 2'.'</br>';
         return $this->player2;
     }else{
         echo 'Both players inactive';
     }
 }
}
?>

