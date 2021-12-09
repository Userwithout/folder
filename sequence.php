<?php
//echo 'aaaaahey';

?>
<html>
<head>
<title>Последовательности</title>
<link rel="shortcut icon" href = "favicon.png" type = "image/png">
<link rel="stylesheet" href="mathlec.css">
<style>
.layer{
overflow-x: scroll;
width: 500px;
height: 25px;
padding: 5px;
border: solid 1px black;
white-space: nowrap;

background: #1af;
border: 2px solid #1af;
border-radius:1px;
}

.bord {
width: 200px;	height: 40px; /* Размеры */
background: #9af; /* Цвет фона */
    /*outline: 2px solid #000;*/ /* Чёрная рамка */
border: 1px solid #000; /* Белая рамка */
border-radius: 5px; /* Радиус скругления */
}



input[type="search"]::-ms-clear {display: none;}
input[type="search"]::webkit-search-cancel-button{display: none;}
</style>
</head>
<body>
<header>
<!--<a href = 'index.html'> <h2><b><i>Главная</i></b> </h2> </a>-->
<div style="float: left"><a href = 'index.php'> <h2><b><i>Главная</i></b> </h2> </a></div>
<div style="float: right"><a href = 'myseq.php'> <h2>Своя последовательность </h2> </a></div>
<div style="margin: 0 auto; width: 150px; text-align: center"><a href = 'sequence.php'><h2>Список последовательностей </h2> </a></div>

<hr>
</header>
<br>


<div style="float: left">
<form>
<input type = "search" name="text">
<input type = "submit" value="Найти">
</form>
<br>
<br>

<form name="form" action="" method="post">
  <table>
     <!--
    <tr>
      <td>Скорость выше, чем:</td>
      <td><input type="text" name="speed_start" /> функция</td>
    </tr>
    <tr>
      <td>Скорость ниже, чем:</td>
      <td><input type="text" name="speed_end" /> функция</td>
    </tr>
    -->
    <tr>
      <td colspan="2">Тип:</td>
    </tr>
    <tr>
      <td>&nbsp &nbsp Основные</td>
      <td>
        <input type="checkbox" name="type[]" value="1" />
      </td>
    </tr>
    <tr>
      <td> &nbsp &nbsp Теория чисел</td>
      <td>
        <input type="checkbox" name="type[]" value="2" />
      </td>
    </tr>
    <tr>
      <td>&nbsp &nbspКомбинаторика</td>
      <td>
        <input type="checkbox" name="type[]" value="3" />
      </td>
    </tr>
    
    
    <tr>

      <td>Есть формула</td>
      <td>
        <input type="checkbox" name="formula" />
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <input type="submit" name="filter" value="Выбрать последовательность" />
      </td>
    </tr>
  </table>
</form>


<!--<br>
<br>-->
</div>

<div style="margin-left: 600; width: 150px; text-align: center">
<table>
<?php
echo $_COOKIE['filter'];

?>

<?php
require_once 'connection.php';
$link = mysqli_connect($host, $user, $password, $database) or die("Error " . mysqli_error($link));
mysqli_set_charset($link, 'utf8');


  function addWhere($where, $add, $and = true) {
    if ($where) {
      if ($and) $where .= " AND $add";
      else $where .= " OR $add";
    }
    else $where = $add;
    return $where;
  }
  function request($query, $link){
      $result = mysqli_query($link, $query) or die("Error " . mysqli_error($link));
      $mrow = [];
      $row = [];
      $j = 0;
    while ($row = mysqli_fetch_array($result))
    {
      //$mrow[$row['id']] = $row;
      $mrow[$j] = $row;
      $j++;
    }
    return $mrow;
  }
  if (!empty($_POST["filter"])) {
      //echo 'haha';
    $where = "";
    //if ($_POST["speed_start"]) $where = addWhere($where, "`price` >= '".htmlspecialchars($_POST["speed_start"]))."'";
    //if ($_POST["speed_end"]) $where = addWhere($where, "`price` <= '".htmlspecialchars($_POST["speed_end"]))."'";
    if ($_POST["type"]) $where = addWhere($where, "`type` IN (".htmlspecialchars(implode(",", $_POST["type"])).")");
    if ($_POST["formula"]) $where = addWhere($where, "`formula` <> ''");
    $query = "SELECT * FROM `sequence`";
    if ($where) $query .= " WHERE $where";
    //echo 'why';
    //echo $query;
    //$result = mysqli_query($link, $query) or die("Error " . mysqli_error($link));
    /*
    $mrow = array();
    $row = array();
    $j = 0;
    while ($row = mysqli_fetch_array($result))
    {
      //$mrow[$row['id']] = $row;
      $mrow[$j] = $row;
      $j++;
    }
    */
    
    $mrow = request($query, $link);
    //print_r($mrow);
    //$row = mysqli_fetch_array($result);
    //var_dump($mrow);
    //if ($result) echo 'hi';
    //print_r($mrow);
    //echo $row['name'];
    //setcookie('filter', $row['id']);
    //echo $row['name'];
    $result = array();
    if (count($mrow) > 1)
    {
    for ($i = 0; $i <= count($mrow); $i++)
    {
        $result[$i] = $mrow[$i]['id'];
        //echo $mrow[$i]['name'];
    }
    }
    else
    {   
        //echo 'kkwjokoekkeflwe';
        //var_dump ($mrow[0]['id']);
        //echo $mrow[0]['id'];
        for ($i = 0; $i <= count($mrow); $i++)
        {
        $result[$i] = $mrow[0]['id'];
        //echo $mrow[$i]['name'];
        }
    }
    //setcookie('filter', serialize($result));
    //setcookie('order', 66);
    //print_r($result);
    //var_dump($row);
  }



//echo $_COOKIE['order'];
//print_r($_COOKIE);
//print_r($result);
$genseq = [];
$genseq = request("select * from sequence", $link);
$linknum = mysqli_connect($host, $user, $password, $database) or die("Error " . mysqli_error($linknum));
$gennum = request("select * from numbers", $linknum);
//print_r($genseq);

//$maseq = [1 => 'Натуральные', 2 => 'Простые', 3 => 'Степени', 4 => 'Фибоначчи', 5 => 'Паскаль', 6 => 'Каталан', 7 => 'Совершенные', 8 => 'Белл'];
//$manum = [1 => '1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18 19 20 21 22 23 24 25 26 27 28 29 30', 2 => '2 3 5 7 11 13 17 19 23 29 31 37 41 43 47 53 59', 3 => '', 4 => '1 1 2 3 5 8 13 21 34 55 89 144 233 377 610 987', 5 => '', 6 => '1 1 2 5 14 42 132 429 1430 4862 16796 58786', 7 =>'1 6 28 496 8128 33550336 8589869056', 8 => '1 1 2 5 15 52 203 877 4140 21147 115975'];


//поиск


function find($stroka, $gennum)
{
    $mas = array();
    for ($i = 0; $i < count($gennum); $i++)
    {
        if (strripos($gennum[$i]['numbers'], $stroka) === false)
        {
            //echo 'hey';
        }
        else
        {
            $mas[] = $i + 1;
        }
        {
            
        }
        
        }
    if (empty($stroka))
    {
        for ($i = 0; $i < count($gennum); $i++)
        $mas[] = $i + 1;
        //echo 'tududu';
    }
    return $mas;
}

//var_dump(find($_GET['text'], $gennum));
if (isset($_GET['text']))
{
$sea = find($_GET['text'], $gennum);
}


//поиск
$maseq = array();
for ($i = 0; $i < count($genseq); $i++)
{
    $maseq[($i +1)] = $genseq[$i]['runame'];
}
$manum = array();
for ($i = 0; $i < count($gennum); $i++)
{
    $manum[$i+1] = $gennum[$i]['numbers'];
}


if (isset($_POST['filter']))
{

    $filter = unserialize(serialize($result));

    for ($i = 1; $i <= count($maseq); $i++)
    {

    
        if (in_array($i, $filter))

        {
            if (!(isset($sea)))
            {
            echo "<tr><td><a href = /numbers.php?number=S".$i." "."style=color:#fff><div class='bord'>".$maseq[$i]."</td></div><td><div class = 'layer'> $manum[$i] </div></td></tr>";
            //echo "<tr><td><a href = /numbers.php?number=S".$i.">".$maseq[$i]."</td><td><div class = 'layer'> $manum[$i]</div></td></tr>";
            }
            else
            {
                if (in_array($i, $sea))
                {
                    echo "<tr><td><a href = /numbers.php?number=S".$i." "."style=color:#fff><div class='bord'>".$maseq[$i]."</td></div><td><div class = 'layer'> $manum[$i] </div></td></tr>";
                }
            }
        }


    }
    
    

    
}
else
{
//var_dump($sea);
for ($i = 1; $i <= count($maseq); $i++)
{
    //echo '<h1> Hello<h1>';
    if (!(isset($sea)))
    {
        //echo 'tududu';
    
    echo "<tr><td><a href = /numbers.php?number=S".$i." "."style=color:#fff><div class='bord'>".$maseq[$i]."</td></div><td><div class = 'layer'> $manum[$i] </div></td></tr>";
    }
    else
    {
        if (in_array($i, $sea))
        {
             echo "<tr><td><a href = /numbers.php?number=S".$i." "."style=color:#fff><div class='bord'>".$maseq[$i]."</td></div><td><div class = 'layer'> $manum[$i] </div></td></tr>";
        }
    }
    //echo "<tr><td>$maseq[$i]</td><td><div class = 'layer'> $manum[$i] </div></td></tr>";
}
}
//echo 'hhha';
?>
</table><div>



<?php

$mas = array("Натуральные", "Степени", "Фибоначчи", "Паскаль"," Каталан", "Совершенные");
if (isset($_GET['text']))
{
/*
if (in_array($_GET['text'], $mas))
{
//echo 'Найдено '.$_GET['text'];


}
*/
//echo 'tududu';
//echo $gennum[0]['numbers'];
/*
else
{
echo 'no';
}
*/


for ($i = 0; $i < count($sea); $i++)
{
    //echo $sea[$i];
    //echo $genseq[$sea[$i]]['runame'].' '.$gennum[$sea[$i]]['numbers'].'<br>';
}
//var_dump($sea);
    
}

?>




</body>
</html>
