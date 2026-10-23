<?php
// 注意: LegacyLens の動作確認用に、意図的に脆弱・古い書き方をしたサンプルです。実行・流用しないでください。
function show() {
    $name = $_GET['name'];
    $html = '<p>';
    $html .= 'Hello ' . $name;
    echo $html;
    $safe = htmlspecialchars($_GET['name'], ENT_QUOTES, 'UTF-8');
    echo $safe;
    $n = (int) $_GET['n'];
    $r = mysqli_query($c, "SELECT * FROM t WHERE n = $n");
}
