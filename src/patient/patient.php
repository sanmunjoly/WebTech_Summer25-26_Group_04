<!DOCTYPE html>
<html>
    <head> 
        <title> Login Page </title>
    </head>
    <body>
        <form>
            <table> 
                <tr>
                    <td> <label for="UserName"> User Name: </label></td> 
                  
                    <td> <input type="text" id="username" name="username" placeholder="Enter Your Name" </td>
                    <!-- <td> <?php echo "Name Required" ?> </td> -->
                </tr>

                <tr>
                    <td> <label for="Password"> Password: </label></td>
                    <td> <input type="password" id="Password" name="Password"</td>
                </tr>
            </table>
            <input type = "Submit" id ="submit" name = "submit" value="LogIn">
            <input type = "reset" id ="reset" name = "reset">
        </form>
    </body>
</html>


<?php
$variable1 = "Hello World";
$number1= 10.6;
$number2= 20.4;
$sum = $number1+$number2;
echo "Sum: $sum";
echo "<br>";
echo "Text from the variable: $variable1";
echo "<h1> Text from the variable: $variable1 </h1>";
$cars=array("Toyota", "Mazda", "Suzuki");
var_dump($cars);
echo "<br>";
$cars2 = array("Brand"=>"Toyota", "Model"=>"2004", "Color"=>"Red");
echo $cars2["Brand"];
?>