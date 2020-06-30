<?php

session_start();

$p = "";

if(isset($_GET['p']))
{
	$p = $_GET['p'];
}
else
{
	$p = "Login";
}

?>

<?php include("Core/Component/Header.php"); ?>

<body>
	<section id="p">
		<?php include("Core/View/" . $p . ".php"); ?>
	</section>

<?php include("Core/Component/Footer.php"); ?>

</body>
</html>
