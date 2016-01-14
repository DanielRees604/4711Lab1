
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        class Game{
            var $position;
            
            function __construct($squares){
                $this->position = str_split($squares);
            }
            
            function winner($token){
                $won = false;
                for($row=0; $row<3; $row++) {
                    $result = true;
                    for($col=0; $col<3; $col++){
                        if ($this->position[3*$row+$col] != $token){
                            $result = false;
                        }
                    }
                    if($result){
                        $won = true;
                    }
                }
                for($col=0; $col<3; $col++) {
                    $result = true;
                    for($row=0; $row<3; $row++){
                        if ($this->position[3*$row+$col] != $token){
                            $result = false;
                        }
                    }
                    if($result){
                        $won = true;
                    }
                }
                if (($this->position[0] == $token) &&
                    ($this->position[4] == $token) &&
                    ($this->position[8] == $token)) {
                    $won = true;
                }else if(($this->position[2] == $token) &&
                        ($this->position[4] == $token) &&
                        ($this->position[6] == $token)) {
                        $won = true;
                }
                return $won;
            }
            function display(){
                echo '<table cols="3" style="font-size:large; font-weight:bold" border="1">';
                echo '<tr>'; // open 
                for ($pos = 0; $pos<9;$pos++){
                    echo $this->show_cell($pos);
                    if($pos %3 ==2) echo'</tr><tr>';//start a new row for the next square
                }
                echo '</tr>'; // close the last row
                echo '</table>';
            }
            function show_cell($which){
                $token = $this->position[$which];
                //deal with the easy case
                if($token <> '-') return '<td>'.$token.'</td>';
                //hard case
                $this->newposition = $this->position;
                $this->newposition[$which] = 'x';
                $move = implode($this->newposition);
                $link = '?board='.$move;
                return '<td><a href="'.$link.'" style="text-decoration: none">-</a></td>'; 
            }
            function pick_move(){
                $emptySpaces = array();
                for ($pos = 0; $pos<9;$pos++){
                    if($this->position[$pos] == '-'){ 
                        $emptySpaces[] = $pos;
                    }
                }         
                $randomNumber = rand(0, count($emptySpaces) -1);
                $this->position[$emptySpaces[$randomNumber]] = 'o';
            }
            function check_board(){
                $empty = true;
                for ($pos = 0; $pos<9;$pos++){
                    if($this->position[$pos] <> '-'){
                        $empty = false;
                    }
                }
                return $empty;
            }
        }
        $over = false;
        
        if (isset($_GET['board']))
            $game = new Game($_GET['board']);
        else
            $game = new Game("---------");
                if($over == false){
            $game->pick_move();       
        }
        
        if ($game->winner('x')){
            echo 'X Wins.';
            $over = true;
        }else if ($game->winner('o')){
            echo 'O Wins.';
            $over = true;
        }else{
            echo 'No winner';
        }

        $game->display();
        $link = "?board=---------";
        echo '<br/><a href="'.$link.'">Reset</a>';
        ?>
    </body>
</html>