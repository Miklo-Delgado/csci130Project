<?php
session_start(); //Starts the session so the $_SESSION variables can be used

// Quick settings
set_time_limit(2);
error_reporting(E_ALL);
ini_set('display_errors', 'On');

// We include the Reersi class so we can use it
include 'libs/Core/Reversi.class.php';


/* If the grid size is not set yet we want don't want the user to be able
to play, they have to enter a size for the grid first before they play*/
if( !isset($_POST['gridSize']) && !isset($_SESSION['gridSize'])  ){ ?>

    
    <div class="dropdown">
        <form action="" method="post">
        <p>Grid size of 4, 6, or 8: <input type="text" name="gridSize" /></p>
        <p><input type="submit"/></p>
    </div>
    
 <?php } 

else{
    /*If the userenters a size for the grid then we assign the gridSize to the $_POST value
     and then give $_SESSION the value to hold so it can carry it on to the rest of the pages
     because the way the game works is that the page is basically recreated once a player moves
    a piece so if we use a $_SESSION to hold the gridSize after the first time we can just use 
    that tha to assign the grideSize*/
    if(isset($_POST['gridSize'])){
        $gridSize = intval($_POST['gridSize']);
        $_SESSION['gridSize'] = $gridSize;
        $_SESSION['time_pre'] = microtime_float();
    }

    else{
        $gridSize = $_SESSION['gridSize'];
    }
    
    // This will actually create the new game
    $reversi = new Core_Reversi($gridSize);

?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta http-equiv="Content-Language" content="en-gb" />
    <title>Reversi board game in PHP and Javascript</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./assets/css/reversi.css" media="screen" />
    
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="./assets/js/reversi.js"></script>
    <script type="text/javascript" src="./assets/js/str_split.js"></script>
    <script type="text/javascript">

    
    // Set up our variables
        var gridSize       = <?php echo $gridSize; ?>,
        boardContent       = new Object,
        boardContentString = "<?php echo $reversi->getBoardAfterTurn(); ?>",
        turnInPlay         = "<?php echo $reversi->getTurn(); ?>",
        turnNext           = turnInPlay == 'b' ? 'w' : 'b',
        coords             = null,
        x                  = false,
        y                  = false,
        xTemp              = false,
        yTemp              = false,
        next               = false,
        continueOn         = true,
        disksChanged       = new Array;
    
    

    // Setup the board
    setBoardContent();
    </script>
</head>
<body>


    <div style="float:left">
        <table id="board">
            <?php echo $reversi->getBoard(); // displays the game board ?>
        </table>
    </div>
    
    <div style="float:left;margin-left:30px">
        <h1>Reversi stats</h1>

        <?php if(isset($_SESSION['email'])){ 
            $userSignedIn = true;
            ?>
        <p> The user <?php echo $_SESSION['email']; ?> is playing with a friend </p>
        <?php } else{ 
            $userSignedIN = false; ?>
            <p> Guest users are playing <p>
        <?php } ?>

        <a href="/Reversi-130/index.php"> homePage</a>
        <!-- Set the stats of the game-->
        <?php
        // Get the stats of the game so far
        $reversiScore  = $reversi->getScore();
        $reversiStatus = $reversi->getGameStatus();
        ?>
        
        <!-- Is the game still over? //-->
        <?php if ($reversiScore['empty'] <= 0) {
            $time_post = microtime_float();
            $game_time = $time_post - $_SESSION['time_pre']; ?>
            <!-- The game is over //-->
            <p><strong>The game has finished!</strong></p>
            
            <p>
                <strong><?php echo $reversi->getFullColor($reversiStatus, true); ?>'s</strong> win,
                the score being
                <strong><?php echo $reversiScore['white']; ?></strong>-<strong><?php echo $reversiScore['black']; Game_Unset(); ?></strong>
                <srong>Game full game time was: <?php echo $game_time; ?> seconds</strong>
            </p>
            
            <p><a href="/Reversi-130/reversiGame.php">Play again, why not?!</a></p>
    
        <?php
        
    } else { 
            
            $time_post = microtime_float();
            $game_time = $time_post - $_SESSION['time_pre'];
            ?>
            <!-- Game is in progress //-->
            <!-- Is it a tie? //-->
            <?php if ($reversiStatus == 'tie') { ?>
                <!-- Tie //-->
                <p>
                    <strong>It's a tie!</strong>
                    <strong><?php echo $reversiScore['white']; ?></strong>-<strong><?php echo $reversiScore['black']; ?></strong>
                    with <strong><?php echo $reversiScore['empty']; ?></strong> disks left to play.
                </p>
            <?php } else { ?>
                <!-- Someone is winning //-->
                <p>
                    <strong><?php echo $reversi->getFullColor($reversiStatus, true); ?>'s</strong> are winning,
                    <strong><?php echo $reversiScore['white']; ?></strong>-<strong><?php echo $reversiScore['black']; ?></strong>
                    with <strong><?php echo $reversiScore['empty']; ?></strong> disks left to play.
                </p>
            <?php } ?>
            
            <!-- Which players turn is it? //-->
            <p><strong><?php echo $reversi->getFullColor($reversi->getTurn(), true); ?></strong>, it is your turn to play a disk!</p>
            
            <!-- How many disks were flipped? //-->
            <?php if ($reversi->getDisksFlipped() >= 1) { ?>
                <!-- Some were flipped //-->
                <p><?php echo $reversi->getDisksFlipped(); ?> disks were flipped!</p>
            <?php } else if (isset($_GET['x'])) { ?>
                <!-- No disks were flipped //-->
                <div class="error">
                    <p>You didn't flip any disks! If you wish to skip your go then <a href="/Reversi-130/reversiGame.php?=<?php echo (int)$_GET['x']; ?>&y=<?php echo (int)$_GET['x']; ?>&turn=<?php echo $_GET['turn'] == 'b' ? 'w' : 'b'; ?>&board=<?php echo htmlentities($_GET['board']); ?>">click here</a>.</p>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
    
</body>
</html>

    <?php } ?>

<?php 
function microtime_float(){

    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

function Game_Unset(){
    unset($_SESSION['gridSize']);
    unset($_SESSION['time_pre']);
    return;
}
?>