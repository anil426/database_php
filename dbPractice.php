<?php
include_once "dbcon.php";

if(isset($_POST['submit']))
{
   $productName=$_POST["productName"];
   $productPrice=$_POST["productPrice"];

echo "the product Name is :".$productName ."and the product price is ". $productPrice;

  if($conn)
  {

    echo "connection established successfully";

    $stmt=$conn->prepare("insert into productmanagement(productName, productPrice) values(:productName,:productPrice) ");
    $stmt->bindParam(':productName',$productName);
    $stmt-> bindParam(':productPrice',$productPrice);

    $insert =$stmt->execute();
   if($insert){
       echo "insert successfully";
   }
   else{
    echo "not inserted";
   }
   
  }
}
?>
<!-- updating the product -->
<?php 
if(isset($_POST['update'])){
$productNameUp=$_POST['productName'];
$productPriceUp=$_POST['productValue'];
$productId=$_POST['productId'];
echo 'the modified product values product name='.$productNameUp .'and productPrice='.$productPriceUp.'with productId='.$productId;
if($conn){

  echo "connection established successfully";

  $stmt=$conn->prepare("update productmanagement SET productName=:productNameUp , productPrice=:productPriceUp where id=".$productId);
  $stmt->bindParam(':productNameUp',$productNameUp);
  $stmt->bindParam(':productPriceUp',$productPriceUp);
  $stmt->execute();

  echo "statement executed";
}
  else{
    echo "insertion failed";
  }

}
?>

<!-- delete the product from the database -->

<?php
include "dbcon.php";
if(isset($_POST['delete'])){
  echo "delete block is executing";

  $id=$_POST['delete'];
  $delete=$conn->prepare("delete from productmanagement where id=".$id);
  $delete->execute();
  
}
else {
  echo "delete is not executing";
}
?>

<?php
if(isset($_POST['edit']))
{
    echo 'edit is executed';
        $id=$_POST['edit'];
    echo 'the value in the id is'.$id."<br/>";

    if($conn){

    echo "connection established successfully";

    $stmt=$conn->prepare("select * from productmanagement where id=".$id);
    $stmt->execute();

    echo "statement executed";

    echo "<pre>";
  $result=$stmt->fetch(PDO::FETCH_OBJ);

  echo '
  <form action="" method="POST"><input type="text" name="productName" value="'.$result->productName.'" ><br/>
  <input type="text" name="productValue" value="'.$result->productPrice.'"><br/>
  <input type="hidden" name="productId" value="'.$result->id.'"><br/>
  <span style="display: inline;">
  <button type="submit" name="update" >update</button>
  <button type="submit" name="cancel" >cancel</button>
  </span></form>';
    }
}
else
    echo '
    <form action="" method="POST"><input type="text" name="productName" placeholder="productName" /><br/>
    <input type="text" name="productPrice" placeholder="productPrice" /><br/>

    <input type="submit" value="submit" name="submit" />
    </form>';

    
?>
<form action="" method="POST">
<table border="2">
<thead>

<th>id</th>
<th>productName</th>
<th>productPrice</th>
<th>edit</th>
<th>delete</th>


</thead>
<tbody>
<?php


   
if($conn){

    echo "connection established successfully";

    $stmt=$conn->prepare("select * from productmanagement");
    $stmt->execute();

    echo "statement executed";

    
  while($result=$stmt->fetch(PDO::FETCH_OBJ)){
    echo '<tr>
       <td>'.$result->id.'</td>
       <td>'.$result->productName.'</td>
       <td>'.$result->productPrice.'</td>
       <td><button type="submit" name="edit" value="'.$result->id.'">edit</button></td>
       <td><button type="submit" name="delete" value="'.$result->id.'">delete</button></td>
       </tr>';
  }
    
}

?>

</tbody>
</table>
</form>
<!-- </body> 
</html> -->