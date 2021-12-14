<?php
include 'config/configuration.php';
if(isset($_POST['delete'])){
    $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);//name of the id of the input field
    $sql = "DELETE FROM pizzas WHERE id = $id_to_delete";
    if(mysqli_query($conn, $sql)){
        //success
        header('Location: index.php');
    }{
        //failure
        echo "query error".mysqli_error($conn);
    }
}

//check request ID parameter
if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // make sql
    $sql = "SELECT * FROM pizzas WHERE id= $id";


    //get the query result
    $result = mysqli_query($conn, $sql);

    //fetch the results in an array format
    $pizza = mysqli_fetch_assoc($result);


    mysqli_free_result($result);
    mysqli_close($conn);

    //print_r($pizza);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <title>Details</title>
</head>

<?php include 'template/header.php';?>
<div class="container center">
    <?php if($pizza):?>
        <h4><?php
            echo htmlspecialchars($pizza['title']);
            ?></h4>
        <p>
            created by
            <?php echo  htmlspecialchars($pizza['email'])?>
            <?php echo date($pizza['created_at']);?>
            <h5>Ingridients</h5>
            <p>
                <?php echo htmlspecialchars($pizza['ingridient']);?>
            </p>
        </p>

        <!-- delete form -->
        <form action="details.php" method="POST">
        <input type="hidden" name="id_to_delete" value="<?php echo $pizza['id']?>">
        <input type="submit" name="delete" value="Delete" class="btn brand z-depth-0">
        </form>
    <?php else: ?>
        <h5>WE have no such pizza</h5>
    <?php endif; ?>
</div>
<?php include 'template/footer.php';?>

</html>