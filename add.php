<?php

include 'config/configuration.php';
    // is set will only run if we have sent data to the server. that is why we have 'submit'
//     if(isset($_GET['submit'])){//check if submit button is pressed
//         echo $_GET['email'];
//         echo    $_GET['ingridients'];
//         echo $_GET['title'];
//     }
$title='';
$ingridient='';
$email='';
$errors = array('email'=>'', 'ingridients'=>'', 'title'=>'');
if(isset($_POST['submit'])){//check if submit button is pressed
    // echo htmlspecialchars($_POST['email']);
    // echo htmlspecialchars($_POST['ingridients']);
    // echo htmlspecialchars($_POST['title']);//prevent xss attacks
    
    //check fields
    if(empty($_POST['email'])){
        $errors['email']=  'email is required <br/>';
    }
    else { 
        $email = $_POST['email'];
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))//FVE IS AN INBUILT FILTER
        {
            $errors['email']= "email must be a valid email address";
        }
        //echo htmlspecialchars($_POST['email']);
    }

    if(empty($_POST['ingridients'])){
        $errors['ingridients']= 'ingrideints is required <br/>';
    }
    else { 
        $ingridient= $_POST['ingridients'];
        if(!preg_match('/^[a-zA-Z\s, ]+$/', $ingridient)){
            $errors['ingridients']= "ingridients must be letters and spaces aonly";
        }
        //echo htmlspecialchars($_POST['ingridients']);
    }
    if(empty($_POST['title'])){
        $errors['title']=  'title is required <br/>';
    }
    else { 
        
        $title= $_POST['title'];
        if(!preg_match('/^[a-zA-Z\s]+$/', $title)){
            $errors['title']=  "title must be letters and spaces aonly";
        }
        //echo htmlspecialchars($_POST['title']);
    }

    if(array_filter($errors)){
        //echo 'there are erros in the form';
    } else{
        // to escape xss
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $ingridients = mysqli_real_escape_string($conn, $_POST['ingridients']);

        // create sql
        $sql="INSERT INTO pizzas(title, email, ingridient) VALUES('$title', '$email', '$ingridient')";
        //save the sql to db
        if(mysqli_query($conn, $sql)){
            //success
            header('location: index.php');// this is to redirect the user to the index.php page.
        }
        else{
            
            echo 'error'.mysqli_error($conn);
        }
        
       
    }
    //end of the post check
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/add.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'template/header.php' ?>
    <section class="container grey-text">
        <h4 class="center">Add a pizaa</h4>
        <form action="add.php" class="white" method="POST">
        <!-- class off white for the white background -->
            <label for="Email">Your email</label>
            <div class="red-text"><?php echo $errors['email'];?></div>
            <input type="text" name="email" id="" value="<?php echo htmlspecialchars($email);?>">
            <label for="Title">Pizza title</label>
            <div class="red-text"><?php echo $errors['title'];?></div>
            <input type="text" name="title" id="" value="<?php echo htmlspecialchars($title)?>">
            <label for="Ingridients">Ingridients (comma seperted):</label>
            <div class="red-text"><?php echo $errors['ingridients'];?></div>
            <input type="text" name="ingridients" id="" value="<?php echo htmlspecialchars($ingridient)?>">
            <div class="center">
                <input type="submit" value="submit" name="submit" class="btn brand z-depth-0"> 
                <!-- btn to make it look like a button barnd for the class we allready created and the z depth to remove any depth it may have -->
            </div>
        </form> 
    </section>
    <?php include 'template/footer.php'?>
</body>
</html>