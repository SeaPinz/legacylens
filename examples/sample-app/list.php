<?php
// 注意: LegacyLens の動作確認用に、意図的に脆弱・古い書き方をしたサンプルです。実行・流用しないでください。
include "config.inc";
$link = mysql_connect($host, $user, $pass);
$id = $_GET['id'];
$sql = "SELECT * FROM items WHERE id = " . $id;
$res = mysql_query($sql);
$sql2 = "SELECT * FROM items WHERE name = '{$_POST['name']}' AND x = 1";
$q = "SELECT * FROM t WHERE id = " . (int)$_GET['id'];
echo "検索語: " . $_GET['q'];
echo htmlspecialchars($_GET['q'], ENT_QUOTES, 'UTF-8');
?>
<p><?= $_REQUEST['msg'] ?></p>
<?php
if (ereg("^[0-9]+$", $id)) {}
while (list($k, $v) = each($arr)) {}
$f = create_function('$a', 'return $a * 2;');
$hash = md5($_POST['password']);
header("Location: " . $_GET['next']);
include $_GET['page'] . ".php";
system("ping " . $_GET['host']);
$o = unserialize($_COOKIE['cart']);
$d = utf8_encode($s);
$enc = mcrypt_encrypt($c, $k, $d, $m);
eval($code);
