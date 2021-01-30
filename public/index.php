<?php
include __DIR__ . "/ProcessData.php";
class Index extends ProcessData
{

    public function __construct()
    {
        session_start();
        $this->startGame();
    }

    public function runApp()
    {
        $this->processGameInput();
        $page = "board.html.php";
        $title = "Tic-Tac-Toe";
        $output = $this->renderView($page);
        echo $this->renderView("layout.html.php", ['title' => $title, 'output' => $output]);
    }
}
