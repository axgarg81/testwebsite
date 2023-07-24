<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf=8">
        <meta name="Alok Garg" content="Luca Website">
        <title>Order</title>
        <link rel="stylesheet" href="css/mystyle.css">
    </head>
    <body>
        <div class="head">
            <img src="images/logo.png" alt="logo" id="logo">
            <h1>Luca's Loaves</h1>
            <h2>We make real bread from the best organic ingredients - 
                by hand, with dedication and with the best of care. </h2>
            <nav>
                <ul>
                    <li><a href="home.html">HOME</a></li>
                    <li><a href="aboutus.html">ABOUT US</a></li>
                    <li><a href="career.html">CAREER</a></li>
                    <li><a href="order.php">ORDER NOW</a></li>
                    <li><a href="contact.html">CONTACT</a></li>
                </ul>
            </nav>
        </div>
        <?php
                

                // for product selection
                // connect with DB
                // variables for db connection
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "agluca";
                //create connection
                $conn = new mysqli($servername,$username,$password,$dbname);
                //check connectio is success of not
                if($conn->connect_error){
                    die("Connection failed ".$conn->connect_error);
                }

                // for cart table
                // declare and assign 0 to qty
                $qty1=0;
                $qty2=0;
                $qty3=0;
                $qty4=0;
                $qty5=0;
                // read values of qty from user input
                if(!EMPTY($_POST['qty1'])){
                    $qty1 = $_POST['qty1'];
                }
                if(!EMPTY($_POST['qty2'])){
                    $qty2 = $_POST['qty2'];
                }
                if(!EMPTY($_POST['qty3'])){
                    $qty3 = $_POST['qty3'];
                }
                if(!EMPTY($_POST['qty4'])){
                    $qty4 = $_POST['qty4'];
                }
                if(!EMPTY($_POST['qty5'])){
                    $qty5 = $_POST['qty5'];
                }
                // sql statement to select all data from products table    
                $sql = "SELECT * FROM PRODUCTS";
                // run sql statement and put all data in $results
                $results = $conn->query($sql);
                // check there are records
                if($results->num_rows >0){
                    echo "<h1>My Cart</h1>";
                    echo "<form method='POST' action='order.php'>";
                    echo "<table class='cart'>";
                    // table heading
                    echo "<tr>
                            <th>ID</th>
                            <th>NAME</th>
                            <th>UNIT PRICE</th>
                            <th>QUANTITY</th>
                            <th>PRICE</th>
                           </tr> ";
                           // declare variable for row number and total
                           $i = 0;
                           $total = 0;
                           $price = 0;
                           // read record by record
                           while($row = $results->fetch_assoc()){
                               $i++; // increment for rows
                               // check qty is not 0
                               if(${"qty$i"}>0){
                                   // calculate price multiply unit price by qty
                                   $price = $row['PRICE'] * ${"qty$i"};
                                   // calculate running total
                                   //$total += $price;
                                   $total = $total + $price;
                                   // format price to 2 decimal
                                   $myprice = number_format($price,2);
                                   //put data into table cells
                                   echo "<tr>
                                        <td>{$row['ID']}</td>
                                        <td>{$row['NAME']}</td>
                                        <td>\${$row['PRICE']}</td>
                                        <td>${"qty$i"}</td>
                                        <td>\${$myprice}</td>
                                   </tr>";

                               }
                           }
                           // format total
                           $total= number_format($total,2);
                           // leave three cells blank and add total
                           echo "<tr><td></td><td></td><td></td><td>TOTAL</td><td>\${$total}</td></tr>";
                           echo "</table>
                                 <input type='submit' value='Empty My Cart'>        
                           </form>";

                }else{
                    echo "No records";
                }

                // create sql statement
                $sql = "SELECT * FROM PRODUCTS";
                $results = $conn->query($sql);
                // create form and table for products
                echo "<form method='POST' action='order.php'>";
                echo "<br><br><br><h1>Select Products</h1>";
                echo "<table class='order'>";
                echo "<tr>
                       <th>ID</th>
                       <th>NAME</th>
                       <th>DESCRIPTION</th>
                       <th>IMAGE</th>
                       <th>PRICE</th>
                       <th>QUANTITY</th>
                       </tr>";
                // declare variable for row number
                $i=0;
                while($row = $results->fetch_assoc()){
                    $i++; // increment
                    echo "<tr>
                            <td>{$row['ID']}</td>
                            <td>{$row['NAME']}</td>
                            <td>{$row['DESCRIPTION']}</td>
                            <td><img src='images/{$row['IMAGE']}'></td>
                            <td>\${$row['PRICE']}</td>
                            <td><input type='number' min=0 max=10 value=0 name ='qty$i'></td>
                            </tr>";

                }


                echo "</table><br><input type='submit' value='Add to Cart'></form>";     

        ?>
       
    </body>
</html>