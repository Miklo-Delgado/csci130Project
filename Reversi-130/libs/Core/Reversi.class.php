<?php
class Core_Reversi
{//so this file is the core of the game, all functionality is checked in this file
    /**
     * we will decide our grid size, we have 4 6 8 available sizes
     *
     * @var int
     * @access private
     */
    private $_gridSize;//only accessable to the class
    
    /**
     * 
     * we store the board coordinates in an array where the y's hold arrays of x's
     * @var array
     * @access private
     */
    private $_boardContent;//hold the content arrays of the board
    
    /**
     * 
     * //we construct the new string after each move has been played
     * @var string
     * @access private
     */
    private $_boardContentAfterTurn;//to hold the updated string of board contents
    
    /**
     * 
     * Who is playing? that's what this is for
     * @var string
     * @access private
     */
    private $_turnInPlay;//we need to keep track of the player in motion
    
    /**
     * 
     *keep track of the x coordinate where piece is
     * @var mixed
     * @access private
     */
    private $_x = false;//we set default as false cause each space should be empty until placed
    
    /**
     * 
     * keep track of the y coordinate where piece is
     * @var mixed
     * @access private
     */
    private $_y = false;//we set default as false cause each space should be empty until placed
    
    /**
     * 
     * we need to keep track of how many pieces were flipped per move
     * @var bool
     * @access private
     */
    private $_disksFlipped = 0;//initially set as zero cause no move has been played and move not yet been played
    
    /**
     * 
     * we will begin by setting the size of the grid based on based in variable gridsize
     * @param $gridSize int 
     * @access public
     */
    public function __construct($gridSize) {
        // we will first set up the board with the board contents and initialize to passed in girdSize ex). 4 6 8.
        $this->setGridSize($gridSize);
        $this->setCoords();
        $this->setBoardString();
        $this->setTurn();
        $this->setBoardContent();
        //initalizing the first move and setting who will go first
        
        //we will set the move and see if valid
        $this->doTurn();
        
        
        //call the funciton to essentially clean the grid and reintialize and see the array.
        $this->doCleanup();
    }
    
    /**
     * we need to grab the passed in grid size from the user and by using the session value set
     *
     * @param $gridSize int
     * @access private
     */
    private function setGridSize($gridSize) {
        
        //initialize the grid size
        $this->_gridSize = (int)$gridSize;
        
        
        //we have to check and see if the grid size passed in will fit our grid option, minninum of 4 max of 8 and in between 6
        if ($this->_gridSize < 4) { // less than 4
            // falls under size
            $this->_gridSize = 4;//give the grid size of 4 to the board game
        } else if ($this->_gridSize > 8) { // greater than 8
            // goes over size
            $this->_gridSize = 8;
        }
    }
    //////////////////////////////////////////////////////////////////////////////////////
    /**
     * 
     * so we need the (x,y) of the piece the player want to play and check if the move is valid or invalid
     * @access private
     */
    private function setCoords() {
        // (X,y)
        if (isset($_GET['x'])) {
            $this->_x = $_GET['x'];
        }
        
        // (x,Y)
        if (isset($_GET['y'])) {
            $this->_y = $_GET['y'];
        }
    }
    
    /**
     * 
     * we need to create the string that will hold the board contents and see where pieces are saved.
     * @access private
     */
    private function setBoardString() {
        
        //when we keep refreshing the page we check and see if there is already a board in play 
        if (isset($_GET['board'])) {
            
            //if there is a board we will be using the contents of the board string to set the board and continue
            $this->_boardContent = $_GET['board'];
        } else {
            
            //if there is no board we will create the board contents with new intialized contents
            $this->_boardContent = str_repeat('-', ($this->_gridSize * $this->_gridSize));

            
            //so when we start with the fresh game of reversi we need to set the starting pieces for the 
            //game board... Remember reversi always starts with 2 white and 2 black in the center of board opp. of eachother
            $startX = ($this->_gridSize / 2) - 1;//middle of the board
            $startX = ($startX * $this->_gridSize) + $startX;//set the piece
            $this->_boardContent = substr_replace($this->_boardContent, 'wb', $startX, 2);
            $this->_boardContent = substr_replace($this->_boardContent, 'bw', ($startX + $this->_gridSize), 2);
        }        
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    /**
     * 
     * //this will store the current player and set what player will be next unless skipped.
     * //so think of this in real time, in real time the person who set the last starting disk is
     * //technically white so black will go first.
     * @access private
     */
    private function setTurn() {
        
        //starting off will be black cause it their turn first
        $this->_turnInPlay = ! isset($_GET['turn']) || $_GET['turn'] == 'b'
            ? 'b'
            : 'w';
    }
    
    /**
     * //we are setting the board content based on the board data from the string.
     * @access private
     */
    public function setBoardContent() {
        
        //we keep track of the board string in the case of no action made.
        $this->_boardContentAfterTurn = $this->_boardContent;

        
        //based on the move we have to convert the string into valid (X,y).
        $this->_boardContent = str_split($this->_boardContent, $this->_gridSize);
        
        
        //go throught the grid and set the appropriat (X,y) for each given (x,Y).
        foreach ($this->_boardContent as $index => $line) {
            
            //we will be at the appropriate space so we will enter in the (X,y).
            $this->_boardContent[$index] = str_split($this->_boardContent[$index], 1);
        }
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    /**
     * Action will commence 
     * so for an action to commence a few criteria must be met first
     * we have to see if all valid coordinats are set and see if they are on the grid or outside the grid
     * and to see if the desired space or any space on the grid is empty or not.
     * 
     *
     * if all is in order then we allow the player to commence with the move.
     * onnce the player has 'clicked' to place the piece we will traverse through the grid.
     *
     * @access public
     */
    public function doTurn() {
        //is the action an action to where we have update the setting
        if ($this->_x === false || $this->_y === false) {//we are checking the (X,Y) to see if they exist
            return false;
        }
        
    
        //next we wanna see if the placed piece will be valid or not.
        else if (! isset($this->_boardContent[$this->_y][$this->_x])) {
            return false;//checking wiht hth board contents and seeing if the desired space is valid
        }
        
        
        //we will chekc witht the boardcontent string to make sure that the desired space is not occupied.
        else if ($this->_boardContent[$this->_y][$this->_x] != '-') {
            return false;
        }

        
        //if all other conditions have been met then we wil be allowing player to commence witht the move.
        $this->_boardContent[$this->_y][$this->_x] = $this->_turnInPlay;
        
        
        //as always when the player makes his/her move, we will need to check if the user took over any enemy pieces.
        $this->doTraverse(0, -1); // We will check the top of the chosen place
        $this->doTraverse(1, -1);  // We will check the tiop right of the chosen place. 
        $this->doTraverse(1, 0);  // We will check the right of the chosen place.
        $this->doTraverse(1, 1);  // We will check the bottom right of the chosen place.
        $this->doTraverse(0, 1);   // We will check the bottom of the chosen place. 
        $this->doTraverse(-1, 1);   // We will check th ebottom left of the chosen place. 
        $this->doTraverse(-1, 0); // We will check the Left of the chosen place . 
        $this->doTraverse(-1, -1); // We will finally check the top left of the chosen place.
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     *okay so no using the board contents from the previous traversing we will see if we can get enemys
     *so when we are traversing we are going to essentially do 3 things, we are going to keep chekcing while taking over
     *enemy disks by adding to the (X,Y), subtracting from (X,Y) or until we reach an edge 'e' or one of our own.
     * @param $xDiff int the difference
     * @param $yDiff int the difference
     * @access private
     */
    public function doTraverse($xDiff, $yDiff) {
       
        //we will initialize the vars to the (X,Y)
        $x = $this->_x;
        $y = $this->_y;
        $continue = true;
        
       
        //we will start traversing through the grid
        do {
            
            //set the testing vars to see if valid move has been made
            $x += $xDiff;
            $y += $yDiff;
            
            
            //check surrounding positions of the piece set.
            $next = isset($this->_boardContent[$y][$x])
                ? $this->_boardContent[$y][$x]
                : 'e'; // just stated in other files for consitiency we 'e' stands for edge.

         
            //check surrounding areas and see what next to placed piece.
            if ($next == 'e' || $next == '-') {
                $continue = false;
            }
            
           
            //we need to keep checking the loop until we have reached one of our own.
            else if ($next == $this->_turnInPlay) {
                
               //have to keep chekcing but we are currently at the our own spot.
                if ($xDiff > 0) { $x--; } else if ($xDiff < 0) { $x++; }
                if ($yDiff > 0) { $y--; } else if ($yDiff < 0) { $y++; }
                
                
                //we must check if the we have gone full circle back to starting positon
                while ($x != $this->_x || $y != $this->_y) {
                    
                    //we need to get the disk that just moved and change the color
                    $this->_boardContent[$y][$x] = $this->_turnInPlay;
                    
                    
                    //this will output the number of disks that were flipped and output to the user.
                    $this->_disksFlipped++;
                    
                   
                    //we need to keep backtracking to the original space until full cirle.
                    if ($xDiff > 0) { $x--; } else if ($xDiff < 0) { $x++; }
                    if ($yDiff > 0) { $y--; } else if ($yDiff < 0) { $y++; }
                }
                
                
                //we have offically gone full circle so we will leave the loop because all potential enemy disks that were flipped
                //have been flipped
                $continue = false;
            }
        } while ($continue);
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
    
     *
     * after a turn has been made we have to make sure the move was actually a valid one, becaseu if the move
     * was invalid then the pice that was just set have to be removed from the board so it doesnt stay and then we
     * force the player to make the another move until the valid one is made which will meet future conditions 
     * 
     * @access private
     */
    private function doCleanup() {
        
        //if we are chekcing to see the disks that were flipped then it was valid.

        if ($this->_disksFlipped >= 1) {
            $this->_turnInPlay = $this->_turnInPlay == 'b'
                ? 'w'//type of pieces
                : 'b';
        }
        
        
        //the (X,Y) were set on the field but the move was invalid so we recycle and have player go again
        else if (! $this->getIsValidMove()) {
           
            //reset the move and have player go again
            $this->_boardContent[$this->_y][$this->_x] = '-';
        }
        
        
        //move was made and turn has been set so we update the board content
        $this->_boardContentAfterTurn = $this->getBoardAfterTurn();
    }
    
    /**
     * we need to check if the move was valid
     *
     * you made a move that didnt flip any pieces so we want the player to flip pieces
     * @access private
     * @return boolean
     */
    private function getIsValidMove() {
        
        //we want the player to flip pieces but if the move they made didnt flip any we check
        return isset($this->_x) && $this->_disksFlipped <= 0
            ? false
            : true;
    }

    /**
     * 
     * 
     * here we will set the board string based on the contents of the board.
     *
     * @access public
     * @return string
     */
    public function getBoardAfterTurn() {
        $board = '';
        for ($y = 0; $y < $this->_gridSize; $y++) {
            $board .= implode($this->_boardContent[$y], '');
        }
        return $board;//the board string
    }

    /**
     * we want to export the board string once the move has finsished
     * @access private
     */
    public function getBoard() {
        
        //begin the output of the board
        $output = '<tr><td class="board-corner">&nbsp;</td>';
        
      
        //set up the rows for the board contents
        $letter = 'a';//in this section we are creating the table with the proper pieces in the place
        for ($x = 0; $x < $this->_gridSize; $x++) {
            $output .= '<th>' . strtoupper($letter++) . '</th>';
        }
        
       
        //end of the rown
        $output .= '</tr>';
        
        
        //we have to go through the (x,y)'s to set appropreiat (x,Y) 
        for ($y = 0; $y < $this->_gridSize; $y++) {
            //set up the rows for the board contents
            $output .= '<tr><th>' . ($y + 1) . '</th>';
            
            //we have to go through the (x,y)'s to set appropreiat (X,y)            
            for ($x = 0; $x < $this->_gridSize; $x++) {
                
                //now we have to check an see which piece are we using what piece are flipping and not flipping
                switch ($this->_boardContent[$y][$x]) {
                    case 'b' : $output .= '<td><img src="./assets/img/disk-b.png" alt="B" class="disk-black" rel="'.$x.':'.$y.'" /></td>'; break;
                    case 'w' : $output .= '<td><img src="./assets/img/disk-w.png" alt="W" class="disk-white" rel="'.$x.':'.$y.'" /></td>'; break;
                    default  : $output .= '<td><a href="?x=' . $x . '&y=' . $y . '&turn=' . $this->_turnInPlay . '&board=' . $this->_boardContentAfterTurn . '" class="disk-empty" rel="'.$x.':'.$y.'"><img src="./assets/img/disk-e.png" alt="" /></a></td>';
                }
            }
            
            //end of the rown
            $output .= '</tr>';
        }
        
        //send the output string to the board contents
        return $output;
    }
    
    /**
     * we have to check what user/player is currently playing and output that 
     *
     * @access public
     * @return string
     */
    public function getTurn() {
        return $this->_turnInPlay;//we will see who is playing
    }
    
    /**
     *this is tell the player(s) what the score is and how many moves left based on available spaces
     * 
     * @access public
     * @return array
     */
    public function getScore() {
        // set the players and get them
        $whiteCount = substr_count($this->_boardContentAfterTurn, 'w');
        $blackCount = substr_count($this->_boardContentAfterTurn, 'b');
        
        // returns scores for each player
        return array(
            'white' => $whiteCount,
            'black' => $blackCount,
            'empty' => ($this->_gridSize * $this->_gridSize) - ($whiteCount + $blackCount)
        );
    }
    
    /**
     * we chekc who is in the lead
     *
     * @access public
     * @return string
     */
    public function getGameStatus() {
        
        //return the stats
        $stats = $this->getScore();
        
        
        //is the first player winning
        if ($stats['black'] > $stats['white']) {
            return 'b';
        }
        
        
        //is the guest winning
        else if ($stats['white'] > $stats['black']) {
            return 'w';
        }
        
        
        //if neiether are winning than its a tie
        return 'tie';
    }

    /**
     * how many pieces did the move flip, we will return it
     * 
     * @access public
     * @return int
     */
    public function getDisksFlipped() {
        return $this->_disksFlipped;
    }

    /**
     * we will giv ethe color of who is winning
     * @access public
     * @param $uppercaseFirstLetter boolean
     * @return string
     */
    public function getFullColor($color, $uppercaseFirstLetter = false) {
        //whos is who and who is winning
        $color = $color == 'w' ? 'white' : 'black';
        
        // And return
        return $uppercaseFirstLetter
            ? ucfirst($color)
            : $color;
    }
}