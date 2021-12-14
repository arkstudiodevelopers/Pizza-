<?php

include 'config/configuration.php';
//connect to db
// $conn = mysqli_connect('localhost', 'root', '','ninja pizza' );
// //check the connection
// if(!$conn){
//     echo 'connection error' .mysqli_connect_error();
// }
// write the query for all pizza
$sql= 'SELECT title, ingridient, id FROM pizzas ORDER BY created_at';// select is for selecting from  * means from all columns

// make the query
$result = mysqli_query($conn, $sql);

//get the array, fetch the resulting rows as array.
$pizza = mysqli_fetch_all($result, MYSQLI_ASSOC);
//print_r($pizza);

mysqli_free_result($result);

// close the connection to the database
mysqli_close($conn);

//explode(',' , $pizza[0]['ingridient']);//to make the ingridients in their own line

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'template/header.php' ?>
    <h4 class="center grey-text">Pizzas</h4>
    <div class="container"><!-- will have a class of center--->
        <div class="row">
            <!-- cycle through different pizza and output them -->
            <?php foreach($pizza as $pizza):?>
                <div class="col s6 md3 ">
                    <div class="card z-depth-0">
                      <div class="card-content center">
                          <h6><?php echo htmlspecialchars($pizza['title']);?></h6>
                          <ul>
                              <?php
                              foreach(explode(',' , $pizza['ingridient'])as $ing){ ?>
                              <li><?php echo htmlspecialchars($ing);?></li>  
                            <?php }  ?>
                            <!-- the above code for ul is used to make the ingridients to be in list form -->
                          </ul>
                        </div>  
                        <div class="card-action right-align">
                            <a class="brand-text" href= "details.php?id=<?php echo $pizza['id'];?>"> more info </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
        </div>
    </div>
    <?php include 'template/footer.php'?>
</body>
</html>