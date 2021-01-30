<?php

class ProcessData
{
    const GAME_PLAY = 1;
    const GAME_OVER = 3;
    const GAME_RESTART = 4;
    private $humanPlayer = "X";
    private $aiPlayler = "O";


    protected function renderView($viewFileName, $variables = [])
    {
        extract($variables);
        ob_start();
        include __DIR__ . '/../templates/' . $viewFileName;
        return ob_get_clean();
    }

    protected function startGame()
    {
        if (!isset($_SESSION['GameState'])) {
            global $gameBoard;
            $gameBoard = ["", "", "", "", "", "", "", "", ""];
            $_SESSION['GameState'] = self::GAME_PLAY;
            $_SESSION['gameBoard'] = $gameBoard;
            $_SESSION['winner'] = 'none';
            $_SESSION['gameOver'] = false;
            $_SESSION["message"] = "";
        }
    }
    protected function restartGame()
    {
        $_SESSION = [];
        unset($_SESSION);
        session_regenerate_id();
        $this->startGame();
    }
    protected function processGameInput()
    {
        switch ($_SESSION['GameState']) {
            case self::GAME_PLAY:
                if (isset($_POST['btnMove']) && !empty($_POST['btnMove'])) {

                    // check if the gameboard is filled
                    if ($this->isBoxAvailable()) {
                        //register player move
                        $_SESSION['gameBoard'][intval($_POST['btnMove'])] = $this->humanPlayer;
                        // check if current move is a win
                        if ($this->isMoveWin()) {
                            // end the game  and call game over
                            $this->gameOver();
                            return;
                        }
                        if ($this->isBoxAvailable()) {
                            //compute AI move
                            $this->computerRandomMove();
                            // check if current move is a win
                            if ($this->isMoveWin()) {
                                // end the game  and call game over
                                $this->gameOver();
                                return;
                            }
                        }
                    } else {
                        // call endGame
                        $this->gameOver();
                        return;
                    }
                }
                break;
            case self::GAME_OVER:
                $this->restartGame();
                break;
            default:
                $this->restartGame();
        }
    }

    private function isMoveWin(): bool
    {
        global $gameBoard;
        $gameBoard = $_SESSION['gameBoard'];

        $player = 1;
        while ($player <= 2) {
            if ($player == 1)
                $tile = $this->aiPlayler;

            else
                $tile = $this->humanPlayer;
            if (
                # horizontal
                ($gameBoard[0] == $tile && $gameBoard[1] == $tile && $gameBoard[2] == $tile) ||
                ($gameBoard[3] == $tile && $gameBoard[4] == $tile && $gameBoard[5] == $tile) ||
                ($gameBoard[6] == $tile && $gameBoard[7] == $tile && $gameBoard[8] == $tile) ||
                # vertical
                ($gameBoard[0] == $tile && $gameBoard[3] == $tile && $gameBoard[6] == $tile) ||
                ($gameBoard[1] == $tile && $gameBoard[4] == $tile && $gameBoard[7] == $tile) ||
                ($gameBoard[2] == $tile && $gameBoard[5] == $tile && $gameBoard[8] == $tile) ||
                # diagonal
                ($gameBoard[0] == $tile && $gameBoard[4] == $tile && $gameBoard[8] == $tile) ||
                ($gameBoard[2] == $tile && $gameBoard[4] == $tile && $gameBoard[6] == $tile)
            ) {
                $_SESSION['winner'] = $tile;
                return true;
            }
            $player++;
        }
        return false;
    }
    private function isBoxAvailable(): bool
    {
        $_SESSION['GameState'] = self::GAME_OVER;
        foreach ($_SESSION['gameBoard'] as $box => $value) {
            if ($value == "") {
                $_SESSION['GameState'] = self::GAME_PLAY;
                return true;
            }
        }
        return false;
    }
    private function computerRandomMove()
    {
        while (true) {
            $test = rand(0, 8);
            if ($_SESSION['gameBoard'][$test] == "") {
                $_SESSION['gameBoard'][$test] = $this->aiPlayler;
                break;
            }
        }
    }
    private function gameOver()
    {
        $_SESSION['gameOver'] = true;
        if ($_SESSION['winner'] == $this->humanPlayer) {
            $_SESSION['GameState'] = self::GAME_OVER;
            $_SESSION["message"] = "<div class=\"message\"> Hurray! You Won!<br/><form method='post'><input type='submit' value='Restart' /></form></div>";
        } else if ($_SESSION["winner"] == $this->aiPlayler) {
            $_SESSION['GameState'] = self::GAME_OVER;
            $_SESSION["message"] = "<div class=\"message\"> Sorry! You Loose! <br/><form method='post'><input type='submit' value='Restart' /></form></div>";
        } else {
            $_SESSION['GameState'] = self::GAME_OVER;
            $_SESSION["message"] = "<div class=\"message\"> Game Tie! <br/><form method='post'><input type='submit' value='Restart' /></form></div>";
        }

        return;
    }
}
