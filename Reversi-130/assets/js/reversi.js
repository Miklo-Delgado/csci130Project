
//We put the pieces of the borad in place based on the string for the board
function setBoardContent() {        
    
    //we call the string split funciton so that we can put the pieces in proper place
    boardContent = str_split(boardContentString, gridSize);
    
    
    //This will set the piece for the y coordinate
    for (var i = 0; i < gridSize; i++) {
        
        //while looping for the y coordinate, we will insert for the x coordinate, 
        //putting the pieces in final place
        boardContent[i] = str_split(boardContent[i], 1);
    }
}


//this function is for seeing if we a disk will be valid in the chosen coordinate.
function doTurn() {
    
    //first we check to see if the chosen space is already being occupied by any other disk
    if (boardContent[y][x] != '-') {
        return false;//if it is true then we will return false and tell the user invalid move
    }

   
    //if the chosen space if valid we will then place the disk down for the user
    boardContent[y][x] = turnInPlay;
    
    
    //but now after placing the disk in the valid check we will now have to check to see if 
    //any disks of the enemy will be flipped or not. so the game will continue.
    doTraverse(0, -1);  // We will check the top of the chosen place. 
    doTraverse(1, -1);  // We will check the tiop right of the chosen place. 
    doTraverse(1, 0);   // We will check the right of the chosen place. 
    doTraverse(1, 1);   // We will check the bottom right of the chosen place. 
    doTraverse(0, 1);   // We will check the bottom of the chosen place. 
    doTraverse(-1, 1);  // We will check th ebottom left of the chosen place. 
    doTraverse(-1, 0);  // We will check the Left of the chosen place . 
    doTraverse(-1, -1); // We will finally check the top left of the chosen place. 
}


//in this function we will be checking the nearby the indexes of the table to take over enemy disks
function doTraverse(xDiff, yDiff) {
    
    //first start will the variables being set.
    xTemp = x;
    yTemp = y;
    continueOn = true;
    
    
    do {
        
        //this is just to check the new coords to see if the enenmy is there for testing
        xTemp += xDiff;
        yTemp += yDiff;

        // What is in the next position?
        //well by using the new testing vars from above we will see if the  enenmy or friend or empty occupies space.
        next = typeof boardContent[yTemp] != "undefined" && typeof boardContent[yTemp][xTemp] != "undefined"
            ? boardContent[yTemp][xTemp]
            : 'e'; 
            //the 'e' is a placeholder that we will be using for teh edge.

        
        //we first have to check if we are hitting an edge on our move or if the space is not occupied by any one else.
        if (next == 'e' || next == '-') {
            continueOn = false;//we will not continue to take over position because next over is an edge.
        }

        
        //So in reversi when we take over an enemy we keep taking over enenmy disks until we connect back to our own friendly disk.
        else if (next == turnInPlay) {
           
            //we check the current disk which will be our own and then step back one so we are at the last open potential disk.

            if (xDiff > 0) { xTemp--; } else if (xDiff < 0) { xTemp++; }
            if (yDiff > 0) { yTemp--; } else if (yDiff < 0) { yTemp++; }
            
            
            //have we gone full circle with our connection of our friendly disks.
            while (xTemp != x || yTemp != y) {
                
                //so if the piece played is taking over the enemy pieces we have to replace that disk with one of our own.
                boardContent[yTemp][xTemp] = turnInPlay;
                
                
                //we use images instead of using canvas shapes so what we do is just change the image instead of changing colors
                //we felt this was gunna be simplier.
                $("img[rel='"+xTemp+":"+yTemp+"']").attr("src", "./assets/img/disk-"+turnInPlay+".png");
                
                
                //So now that we have changed the image of the new disk, we have to reset the board with the new pieces in place
                disksChanged[disksChanged.length] = [xTemp, yTemp];

                
                //We will be going back to do another update on replacements

                if (xDiff > 0) { xTemp--; } else if (xDiff < 0) { xTemp++; }
                if (yDiff > 0) { yTemp--; } else if (yDiff < 0) { yTemp++; }
            }
            
            
            //now that we have finished switching all of the new placed disks we can exit.
            continueOn = false;
        }
    } while (continueOn);
}


//So if you look over the game you will notice that if you hover over certain places on the board the disks will change, but what happens 
//if you dont place the piece there? well we have to reset back to default before the hover taken place.
function resetDisks() {
    
    //if the was no piece there to begin with then we will reset it back to empty
    boardContent[y][x] = "-";
    
    
    //here we will initializwe the vars
    var disksChangedLength = disksChanged.length;
    
    
    //for the disks that were changed we want to loop through and go over.
    for (var i = 0; i < disksChangedLength; i++) {
        
        //reinitialize the piece back..so basically update
        $("img[rel='"+disksChanged[i][0]+":"+disksChanged[i][1]+"']").attr("src", "./assets/img/disk-"+turnNext+".png");
        
        // after reinitializing the piece we have to reinitialize the board so we update the bord
        boardContent[disksChanged[i][1]][disksChanged[i][0]] = turnNext;
    }
    
    
    //update the pieces that were changed and put into an array for future use
    disksChanged = new Array;
}


//Now we use the document function to now set the board
$(document).ready(function() {
    
    //now if the user hovers over the empty slot on the table we will see the change activate.
    $(".disk-empty").mouseenter(function() {
        
        //we grab the user and see who is in play and switch the piece color/  black or white.
        $("img", this).attr("src", "./assets/img/disk-"+turnInPlay+".png");
        
        
        //the coordinates(x,y) for the table will be set bbaseed on the user move.
        coords = $(this).attr("rel");
        coords = coords.split(':');
        x      = parseInt(coords[0]);
        y      = parseInt(coords[1]);
        
        
        //call the turn function to set the moves turn
        doTurn();
    }).mouseleave(function() {
        
        //when the player hovers over the empty spot we have to update it.
        $("img", this).attr("src", "./assets/img/disk-e.png");
        
        
        //finally updaate the pieces on the board.
        resetDisks();
    });
});