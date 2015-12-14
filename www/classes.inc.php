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
 private $winnerCells;
 private $currentPlayer = 1;
 private $winner;
 
 private $player1;
 private $player2;
 /**
 * Делает поиск выигравшей комбинации, проходя по всему полю и проверяя
 * 4 направления (горизонталь, вертикаль и 2 диагонали).
 */
 private function checkWinner() {
    for($y = 0; $y < $this->fieldSize; $y++) {
        for($x = 0; $x < $this->fieldSize; $x++) {
            $this->checkLine($x, $y, 1, 0);
            $this->checkLine($x, $y, 1, 1);
            $this->checkLine($x, $y, 0, 1);
            $this->checkLine($x, $y, -1, 1);
        }
    }
    if($this->winner) {
        $this->currentPlayer = null;
    }
 }
 /**
 * Проверяет, а не находится ли в этом месте поля выигрышная комбинация
 * из необходимого числа крестиков или ноликов.
 * Если выигрышная комбинация найдена, запоминает победителя
 * и саму выигрышную комбинацию в массиве winnerCells.
 *
 * @param $startX начальная точка, от которой проверять наличие комбинации
 * @param $startY
 * @param $dx направление, в котором искать комбинацию
 * @param $dy
 */
private function checkLine($startX, $startY, $dx, $dy) {
    $x = $startX;
    $y = $startY;
    $field = $this->cells;
    $value = isset($field[$x][$y])? $field[$x][$y]: null;
    $cells = array();
    $foundWinner = false;
    if($value) {
        $cells[] = array($x, $y);
        $foundWinner = true;
        for($i=1; $i < $this->rowSize; $i++) {
            $x += $dx;
            $y += $dy;
            $value2 = isset($field[$x][$y])? $field[$x][$y]: null;
            if($value2 == $value) {
                $cells[] = array($x, $y);
            } else {
                $foundWinner = false;
                break;
            }
        }
    }
    if($foundWinner) {
        foreach($cells as $cell) {
            $this->winnerCells[$cell[0]][$cell[1]] = $value;
        }
        $this->winner = $value;
    }
}
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
     $this->winningCells = array();
     $this->cells = array();
     $this->winner = null;
     $this->player1 = new Player(1);
     $this->player2 = new Player(0);
 }
 public function makeMove($x, $y) {
    // Учитываем ход, если выполняются все условия:
    // 1) игра ещё идет,
    // 2) клетка находится в пределах игрового поля.
    // 3) в поле на указанном месте ещё пусто,
    if(($this->currentPlayer)&&(($x >= 0) && ($x < $this->fieldSize))&&
            (($y >= 0) && ($y < $this->fieldSize))&&(empty($this->cells[$x][$y])))
    {
        $current = $this->currentPlayer;
        $this->cells[$x][$y] = $current;
        $this->currentPlayer = ($current == 1) ? 2 : 1;  
        $this->checkWinner();
    }
 }
 public function getRowSize()       { return $this->rowSize; }
 public function getCells()         { return $this->cells; }
 public function getFieldSize()     { return $this->fieldSize; }
 public function getCurrentPlayer() { return $this->currentPlayer; }
 public function getWinner()        { return $this->winner; }
 public function getWinnerCells()   { return $this->winnerCells; }
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

