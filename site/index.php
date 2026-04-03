<?php
$db = new mysqli('db', 'root', 'pass', 'chat');
$db->query("CREATE TABLE IF NOT EXISTS msg (id INT AUTO_INCREMENT PRIMARY KEY, ip VARCHAR(50), text TEXT, time TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");

if($_POST) {
  $ip = $_SERVER['REMOTE_ADDR'];
  $text = htmlspecialchars($_POST['text']);
  if(trim($text)) $db->query("INSERT INTO msg (ip, text) VALUES ('$ip', '$text')");
  header("Location: /");
  exit;
}

$rows = $db->query("SELECT * FROM msg ORDER BY id DESC LIMIT 100");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Chat</title>
  <style>
    body {font:13px Arial; max-width:400px; margin:40px auto; background:#f5f5f5}
    form {display:flex; gap:5px; margin-bottom:15px}
    input {flex:1; padding:5px; border:1px solid #ccc}
    button {padding:5px 15px; background:#007bff; color:white; border:0}
    #chat {background:white; padding:10px; border:1px solid #ddd; min-height:200px}
    .m {margin:5px 0; padding:5px; border-bottom:1px solid #eee}
    b {color:#666}
  </style>
</head>
<body>

<h2>Chat</h2>
<form method="post">
  <input name="text" placeholder="Сообщение..." autocomplete="off">
  <button>Send</button>
</form>

<div id="chat">
<?php foreach($rows as $r): ?>
  <div class="m"><b><?=$r['ip']?></b><br><?=htmlspecialchars($r['text'])?></div>
<?php endforeach ?>
</div>

</body>
</html>
