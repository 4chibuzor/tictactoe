<?php
// Start the table
global $gameBoard;

$table = "<table border=0 cellpadding=0 cellspacing=0>";
$iLoop = 0;
for ($iRow = 0; $iRow < 5; $iRow++) {
    $table .= "<tr>\n";
    for ($iCol = 0; $iCol < 5; $iCol++) {
        if ($iRow == 1 || $iRow == 3) {
            $table .= "<td width=\"12\" height=\"5\"align=\"center\" valign=\"middle\"bgcolor=\"#000000\">&nbsp;</td>\n";
        } else {
            if ($iCol == 1 || $iCol == 3) {
                $table .= "<td width=\"12\" height=\"115\" align=\"center\" valign=\"middle\" bgcolor=\"#000000\">&nbsp;</td>\n";
            } else {
                $table .= "<td width=\"115\" height=\"115\"align=\"center\" valign=\"middle\">";
                if ($gameBoard[$iLoop] == "X") {
                    $table .= "<div>X</div>";
                } else if ($gameBoard[$iLoop] == "O") {
                    $table .= "<div>O</div>";
                } else {
                    $table .= "<input type=\"submit\" name=\"btnMove\" \ value=\" " . $iLoop . "\"";
                    if ($_SESSION['gameOver']) {
                        $table .= "disabled='true'";
                    }
                    $table .= ">";
                }
                $table .= "</td>\n";
                $iLoop++;
            }
        }
    }
    $table .= "</tr>\n";
}
// End the table
$table .= "</table>";
printf($table);
