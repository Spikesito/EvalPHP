<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./static/styles/style2.css"/>
    <link
        href="https://fonts.googleapis.com/css?family=Allerta Stencil"
        rel="stylesheet"
    />
</head>
<body>
    <div id="container">
        <h2>Your page has been loaded</h2>
        <h2>please check your data base</h2>
    </div>
</body>
</html>

<?php

require_once 'vendor/autoload.php';

// $faker = Faker\Factory::create();

$db = new PDO('mysql:host=localhost;dbname=ecom','root','');
//$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$db->query("DELETE FROM rates");
$db->query("DELETE FROM address");
$db->query("DELETE FROM photoproduct");
$db->query("DELETE FROM payments");
$db->query("DELETE FROM invoiceline");
$db->query("DELETE FROM invoices");
$db->query("DELETE FROM commandline");
$db->query("DELETE FROM products");
$db->query("DELETE FROM category");
$db->query("DELETE FROM carts");
$db->query("DELETE FROM users");
$db->query("DELETE FROM photos");


$products = file_get_contents('https://my.api.mockaroo.com/ecommerce?key=30edd6b0');
$products = json_decode($products);


foreach($categories as $category) {
    $db->query("
        INSERT INTO category (Name)
        VALUES('{$category}')
    ");
} // ok

foreach($products as $p) {
    $dateproduct = date('d-m-Y',date_timestamp_get($faker->dateTimeBetween('-2 years','now')));
    $categoryid = $db->query("SELECT CategoryId FROM category order by RAND() LIMIT 1")->fetch()[0];;
    $db->query("
        INSERT INTO products (ProductName, Price, Quantity, Publishers, CategoryId, CreationDate, Description)
        VALUES('{$p->productname}','{$faker->randomFloat(2,0.50,10)}','{$faker->numberBetween(2,156)}','{$publishers[$nb_Publi]}','{$categoryid}','{$dateproduct}','{$faker->paragraph(10)}')
        ");
    $productid = $db->lastInsertId();
    $db->query("
        INSERT INTO photos (Path, Width, Height)
        VALUES('{https://picsum.photos/200}',360,360);
    ");
    $photoid = $db->lastInsertId();
    $db->query("
        INSERT INTO photoproduct (PhotoId, ProductId)
        VALUES('{$photoid}','${productid}')
    ");
} // ok

foreach(range(1, 1200) as $x) {
    $firstname = $faker->firstName();
    $dateUser = $faker->date('d-m-Y','-20 years');
    $db->query("
        INSERT INTO users (FirstName, LastName, Email, Password, Birthdate, Role)
        VALUES('{$firstname}','{$faker->lastName()}','{$faker->email()}',MD5('{$faker->password()}'),'{$dateUser}', '0')
    ");

    $userid = $db->lastInsertId();
    $postcode = intval($faker->postcode());
    $db->query("
        INSERT INTO address (UserId, AddressName, City, Country, PostalCode, AddressOwner)
        VALUES('{$userid}','{$faker->streetAddress()}','{$faker->city()}','{$countries[random_int(0, sizeof($countries)-1)]}','{$postcode}','{$faker->lastName()}')
    ");
    
    $db->query("
        INSERT INTO carts (UserId)
        VALUES('{$userid}')
    ");
    // $cartid = $db->lastInsertId();
    // $product = $db->query("SELECT ProductId, Price FROM products order by RAND() LIMIT 1")->fetch();
    // $quantity = $faker->numberBetween(2,5);
    // $totalprice = $quantity * $product[1];
    // $db->query("
    //     INSERT INTO commandline (CartId, ProductId, Quantity, TotalPrice)
    //     VALUES('{$cartid}','{$product[0]}','{$quantity}','{$totalprice}')
    // ");
}

// foreach(range(1, 1200) as $x) {
//     $userid = $db->query("SELECT UserId FROM users order by RAND() LIMIT 1")->fetch()[0];
//     $product = $db->query("SELECT ProductId, CreationDate FROM products order by RAND() LIMIT 1")->fetch();
//     $daterate = date('d-m-Y', date_timestamp_get($faker->dateTimeBetween('{$product[1]}','now')));
//     $db->query("
//         INSERT INTO rates (UserId, ProductId, Advice, Date, Note)
//         VALUES ('{$userid}','{$product[0]}','{$faker->paragraph(10)}','{$daterate}','{$faker->randomFloat(1,0,5)}')    
//     ");
// }

foreach(range(1, 1200) as $x) {
    $user = $db->query("SELECT UserId, CONCAT(FirstName, ' ', LastName) AS FullName FROM users order by RAND() LIMIT 1")->fetch();
    $product = $db->query("SELECT ProductId, Price, CreationDate FROM products order by RAND() LIMIT 1")->fetch();
    $quantity = $faker->numberBetween(2,5);
    $totalprice = $quantity * $product[1];
    $dateinvoice = date('d-m-Y', date_timestamp_get($faker->dateTimeBetween('{$product[2]}','now')));
    $db->query("
        INSERT INTO invoices (UserId, Date)
        VALUES('{$user[0]}','{$dateinvoice}')
    ");
    $invoiceid = $db->lastInsertId();
    $db->query("
        INSERT INTO invoiceline (ProductId, InvoiceId, Quantity, TotalPrice)
        VALUES('{$product[0]}','{$invoiceid}','{$quantity}','{$totalprice}')
    ");
    $randCCV = random_int(100, 999);
    $db->query("
        INSERT INTO payments (UserId, CreditCardNum, CCV, ExpirationDate, Owner)
        VALUES('{$user[0]}', MD5('{$faker->creditCardNumber()}'), '{$randCCV}', MD5('{$faker->creditCardExpirationDateString()}'), '{$faker->lastName()}')
    ");
}

?>