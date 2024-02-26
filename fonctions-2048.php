<?php
function affiche_sept_variables()
{
    echo "HTTP_USER_AGENT=";
    echo $_SERVER["HTTP_USER_AGENT"];
    echo "<br />";
    echo "HTTP_HOST=";
    echo $_SERVER["HTTP_HOST"];
    echo "<br />";
    echo "DOCUMENT_ROOT=";
    echo $_SERVER["DOCUMENT_ROOT"];
    echo "<br />";
    echo "SCRIPT_FILENAME=";
    echo $_SERVER["SCRIPT_FILENAME"];
    echo "<br />";
    echo "PHP_SELF=";
    echo $_SERVER["PHP_SELF"];
    echo "<br />";
    echo "REQUEST_URI=";
    echo $_SERVER["REQUEST_URI"];
    echo "<br />";
    echo "action-joueur=";
    echo $_GET["action-joueur"];
    echo "<br />";
}

function write_log($mesg)
{
    $file = file("./logs-2048.txt");
    if (sizeof($file) == 50) {
        unset($file[0]);
        $file[50] = $mesg . "\n";
        file_put_contents("./logs-2048.txt", $file);
    } else {
        file_put_contents("./logs-2048.txt", $mesg . "\n", FILE_APPEND);
    }
}

function affiche_logs($nbl)
{
    $logs = file("./logs-2048.txt");
    $size = sizeof($logs);
    foreach ($logs as $i => $line) {
        if ($i >= $size - $nbl) {
            echo "<span class=" .
                htmlspecialchars($line) .
                ">Ligne " .
                ($i + 1) .
                " : " .
                htmlspecialchars($line) .
                "</span><br />\n";
        }
    }
}

function affiche_score()
{
    global $score;
    if (isset($_GET["action-joueur"]) && $_GET["action-joueur"] == "new") {
        write_log("score = " . $score);
    }
    echo $score;
}

function score_vers_fichier()
{
    global $score;
    file_put_contents("./score.txt", $score);
}

function fichier_vers_score()
{
    global $score;
    $score = file("./score.txt")[0];
}

function matrice_vers_fichier()
{
    global $grille;
    $matrice = "";
    for ($i = 0; $i < 4; $i++) {
        for ($j = 0; $j < 4; $j++) {
            $matrice .= $grille[$i][$j] . " ";
        }
        $matrice .= "\n";
    }
    file_put_contents("./grille.txt", $matrice);
}

function fichier_vers_matrice()
{
    global $grille;
    $matrice = file("./grille.txt");
    for ($i = 0; $i < 4; $i++) {
        $valeurs = explode(" ", $matrice[$i]);
        for ($j = 0; $j < 4; $j++) {
            $grille[$i][$j] = $valeurs[$j];
        }
    }
}

function affiche_case($i, $j)
{
    global $grille;
    $value = $grille[$i][$j];
    if ($value != 0) {
        echo "<td class='val-".$value."'>".$value."</td>";
    } else {
        echo "<td></td>";
    }
}

function tirage_position_vide()
{
    global $grille;
    do {
        $i = rand(0, 3);
        $j = rand(0, 3);
    } while ($grille[$i][$j] != 0);
    return [$i, $j];
}

function grille_pleine()
{
    global $grille;
    for ($i = 0; $i < 4; $i++) {
        for ($j = 0; $j < 4; $j++) {
            if ($grille[$i][$j] == 0) {
                return false;
            }
        }
    }
    return true;
}

function tirage_2ou4()
{
    return rand(1, 2) * 2;
}

function place_nouveau_nb()
{
    global $grille;
    $coord = tirage_position_vide();
    $grille[$coord[0]][$coord[1]] = tirage_2ou4();
}

function nouvelle_partie()
{
    global $score, $grille;
    $score = 0;
    $grille = array_fill(0, 4, array_fill(0, 4, 0));
    for ($i = 0; $i < 2; $i++) {
        $coord = tirage_position_vide();
        $grille[$coord[0]][$coord[1]] = 2;
    }
}

function decale_ligne_gauche($l)
{
    global $grille;
    $ligne = array_fill(0, 4, 0);
    $j = 0;
    for ($i = 0; $i < 4; $i++) {
        if ($grille[$l][$i] != 0) {
            $ligne[$j] = $grille[$l][$i];
            $j++;
        }
    }
    $grille[$l] = $ligne;
}

function decale_ligne_droite($l)
{
    global $grille;
    $ligne = array_fill(0, 4, 0);
    $j = 3;
    for ($i = 3; $i > -1; $i--) {
        if ($grille[$l][$i] != 0) {
            $ligne[$j] = $grille[$l][$i];
            $j--;
        }
    }
    $grille[$l] = $ligne;
}

function decale_col_haut($c)
{
    global $grille;
    $colonne = array_fill(0, 4, 0);
    $j = 0;
    for ($i = 0; $i < 4; $i++) {
        if ($grille[$i][$c] != 0) {
            $colonne[$j] = $grille[$i][$c];
            $j++;
        }
    }
    for ($i = 0; $i < 4; $i++) {
        $grille[$i][$c] = $colonne[$i];
    }
}

function decale_col_bas($c)
{
    global $grille;
    $colonne = array_fill(0, 4, 0);
    $j = 3;
    for ($i = 3; $i > -1; $i--) {
        if ($grille[$i][$c] != 0) {
            $colonne[$j] = $grille[$i][$c];
            $j--;
        }
    }
    for ($i = 3; $i > -1; $i--) {
        $grille[$i][$c] = $colonne[$i];
    }
}

function fusion_ligne_gauche($l)
{
    global $grille, $score;
    if ($grille[$l][0] == $grille[$l][1]) {
        $score += 2 * $grille[$l][0];
        $grille[$l][0] = 2 * $grille[$l][0];
        $grille[$l][1] = 0;
        if ($grille[$l][2] == $grille[$l][3]) {
            $score += 2 * $grille[$l][2];
            $grille[$l][2] = 2 * $grille[$l][2];
            $grille[$l][3] = 0;
        }
    } elseif ($grille[$l][1] == $grille[$l][2]) {
        $score += 2 * $grille[$l][1];
        $grille[$l][1] = 2 * $grille[$l][1];
        $grille[$l][2] = 0;
    } elseif ($grille[$l][2] == $grille[$l][3]) {
        $score += 2 * $grille[$l][2];
        $grille[$l][2] = 2 * $grille[$l][2];
        $grille[$l][3] = 0;
    }
}

function fusion_ligne_droite($l)
{
    global $grille, $score;
    if ($grille[$l][2] == $grille[$l][3]) {
        $score += 2 * $grille[$l][3];
        $grille[$l][3] = 2 * $grille[$l][3];
        $grille[$l][2] = 0;
        if ($grille[$l][0] == $grille[$l][1]) {
            $score += 2 * $grille[$l][1];
            $grille[$l][1] = 2 * $grille[$l][1];
            $grille[$l][0] = 0;
        }
    } elseif ($grille[$l][1] == $grille[$l][2]) {
        $score += 2 * $grille[$l][2];
        $grille[$l][2] = 2 * $grille[$l][2];
        $grille[$l][1] = 0;
    } elseif ($grille[$l][0] == $grille[$l][1]) {
        $score += 2 * $grille[$l][0];
        $grille[$l][0] = 2 * $grille[$l][0];
        $grille[$l][1] = 0;
    }
}

function fusion_col_haut($c)
{
    global $grille, $score;
    if ($grille[0][$c] == $grille[1][$c]) {
        $score += 2 * $grille[0][$c];
        $grille[0][$c] = 2 * $grille[0][$c];
        $grille[1][$c] = 0;

        if ($grille[2][$c] == $grille[3][$c]) {
            $score += 2 * $grille[2][$c];
            $grille[2][$c] = 2 * $grille[2][$c];
            $grille[3][$c] = 0;
        }
    } elseif ($grille[1][$c] == $grille[2][$c]) {
        $score += 2 * $grille[1][$c];
        $grille[1][$c] = 2 * $grille[1][$c];
        $grille[2][$c] = 0;
    } elseif ($grille[2][$c] == $grille[3][$c]) {
        $score += 2 * $grille[2][$c];
        $grille[2][$c] = 2 * $grille[2][$c];
        $grille[3][$c] = 0;
    }
}

function fusion_col_bas($c)
{
    global $grille, $score;
    if ($grille[2][$c] == $grille[3][$c]) {
        $score += 2 * $grille[3][$c];
        $grille[3][$c] = 2 * $grille[3][$c];
        $grille[2][$c] = 0;

        if ($grille[0][$c] == $grille[1][$c]) {
            $score += 2 * $grille[1][$c];
            $grille[1][$c] = 2 * $grille[1][$c];
            $grille[0][$c] = 0;
        }
    } elseif ($grille[1][$c] == $grille[2][$c]) {
        $score += 2 * $grille[2][$c];
        $grille[2][$c] = 2 * $grille[2][$c];
        $grille[1][$c] = 0;
    } elseif ($grille[0][$c] == $grille[1][$c]) {
        $score += 2 * $grille[0][$c];
        $grille[0][$c] = 2 * $grille[0][$c];
        $grille[1][$c] = 0;
    }
}

?>
