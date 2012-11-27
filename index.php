<?php
    session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C**DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Главная страница</title>
		
		<link rel="stylesheet" type="text/css" href="styles.css">

        <script type="text/javascript">


        </script>
	</head>
	<body>
		<div class="main_block">

			<?php
            include ($_SERVER['DOCUMENT_ROOT']."/header.php");
            if (!isset($_GET['type'])) {
                include($_SERVER['DOCUMENT_ROOT']."/main.php");
            } else if ($_GET['type'] === 'store'){
                include($_SERVER['DOCUMENT_ROOT']."/store.php");
            } else if ($_GET['type'] === 'tech') {
                include($_SERVER['DOCUMENT_ROOT']."/tech.php");
            } else if ($_GET['type'] === 'add_product') {
                include($_SERVER['DOCUMENT_ROOT']."/add_article.php");
            } else if ($_GET['type'] === 'basket') {
                include($_SERVER['DOCUMENT_ROOT']."/basket.php");
            } else if ($_GET['type'] === 'about_product') {
                if (isset($_GET['id'])) {
                    include($_SERVER['DOCUMENT_ROOT']."/about_product.php");
                }
            }
            ?>

<div style="clear: both;"></div>
			<?php
                include($_SERVER['DOCUMENT_ROOT']."/bottom.php");
            ?>
		</div>
	</body>
</html>