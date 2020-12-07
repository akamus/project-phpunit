<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="qconc.php" method="post">
<input type="text" name="search" id="" >
<input type="submit" value="RUN">

</form>
    
</body>
</html>

<?php

echo file_get_contents('https://www.qconcursos.com');