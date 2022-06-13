<!DOCTYPE html>
<html lang="en">
<head>
 <style>
div.gallery {
  margin: 5px;
  border: 1px solid #ccc;
  float: left;
  width: 180px;
}

div.gallery:hover {
  border: 1px solid #777;
}

div.gallery img {
  width: 100%;
  height: auto;
}

div.name {
  padding: 15px;
  text-align: center;
}
</style>
 <meta charset="UTF-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Document</title>
</head>
<body>

<h1>Image Gallery Site Project</h1>
<h2>Getting the most recently uploaded pictures on Flickr and insert it into a Postgre database</h2>
<br>
<br>
<div id="parnet_holder" class="gallery"></div>

 <script>
  let parentHolderElem = document.getElementById("parnet_holder");
  let fetchBtn = document.getElementById("fetch_btn");

fetchNewImages();

function fetchNewImages() {
  let xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function () {

   if (this.readyState == 4 && this.status == 200) {

    let xhrResObj = JSON.parse(this.responseText);

    for (let i = 0; i < xhrResObj.photos.photo.length; i++) {
     let imgURL = xhrResObj.photos.photo[i].url_w;
     let imgName = xhrResObj.photos.photo[i].title;
     let imgLikes = 0;
          let childHolderElem = document.createElement("div");
     let imgElem = document.createElement("img");
     imgElem.width = "600";
     imgElem.height = "400";
          imgElem.src = imgURL;

     let nameElem = document.createElement("div");
     nameElem.class = "name";
     nameElem.innerText = imgName;

let likesBtnElem = document.createElement("button");
likesBtnElem.innerText = ("Likes= " + imgLikes);
likesBtnElem.addEventListener("click", function() {


})

let idAttrib = document.createElement("p");
idAttrib.value = i+1;
idAttrib.hidden = true;

let imgNameAttrib = document.createElement("p");
imgNameAttrib.value = imgName;
imgNameAttrib.hidden = true;

let imgURLAttrib = document.createElement("p");
imgURLAttrib.value = imgURL;
imgURLAttrib.hidden = true;

let imgLikesAttrib = document.createElement("p");
imgLikesAttrib.value = imgLikes;
imgLikesAttrib.hidden = true;

     childHolderElem.appendChild(idAttrib);
     childHolderElem.appendChild(imgNameAttrib);
     childHolderElem.appendChild(imgURLAttrib);
     childHolderElem.appendChild(imgLikesAttrib);


     childHolderElem.appendChild(imgElem);
          childHolderElem.appendChild(nameElem);
                    childHolderElem.appendChild(likesBtnElem);
               parentHolderElem.appendChild(childHolderElem);
    }
   }
  }

  // xhr.open("GET", "https://api.flickr.com/services/rest/?method=flickr.photos.getRecent&per_page=10&format=json&nojsoncallback=1&extras=url_w", true);
  //   xhr.setRequestHeader("api_key", "6224b5b7fcfc0bee93ab038108a46c1b");
  xhr.open("GET", "https://api.flickr.com/services/rest/?per_page=10&format=json&nojsoncallback=1&api_key=6224b5b7fcfc0bee93ab038108a46c1b&extras=url_w&method=flickr.photos.search&text=tree&safe_search=1", false);
  //xhr.setRequestHeader("api_key", "6224b5b7fcfc0bee93ab038108a46c1b");
  
  xhr.send();

}

 </script>

<?php

//echo "hello world project";
// host=ec2-3-211-221-185.compute-1.amazonaws.com
// port=5432
// database=d4cqtfhq9c5h0t
// username=lkyhmxaakgvdzz
// password=5c4f13693ff2fec787ea707d97981c064a6d8254bce6a0db009b231c89526760

connectToDB();
insertToDB();

function insertToDB() {

$parentHolder = $dom->getElementsByTagName('div')->item(0);

for ($i = 0; $i <= 9; $i++) {

 $childHolder = $parentHolder->getElementsByTagName('div')->item(i);
 $attribs = $childHolder->getElementsByTagName('p');

   $idAttrib = $attibs.item(0)->attributes->getNamedItem("value")->value;
   $nameAttrib = $attibs.item(1)->attributes->getNamedItem("value")->value;
   $likesAttrib = $attibs.item(2)->attributes->getNamedItem("value")->value;
   $urlAttrib = $attibs.item(3)->attributes->getNamedItem("value")->value;

   



   try {
  $sql = "INSERT INTO pictures (pic_name, pic_likes, pic_url) VALUES ($nameAttrib, $likesAttrib, $urlAttrib)";
  // use exec() because no results are returned
  $$GLOBALS["pdo"]->exec($sql);
  echo "New record created successfully";
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}

} // end of i loop

}

function fetchDB() {
   $sql = 'SELECT * FROM pictures';
  $sth = $GLOBALS["pdo"]->prepare($sql);
$sth->execute();

/* Fetch all of the remaining rows in the result set */
print("Fetch all of the remaining rows in the result set:\n");
$result = $sth->fetchAll(\PDO::FETCH_ASSOC);
print_r($result);

  // $sql = 'SELECT * FROM pictures';
  // $stmt = $pdo->prepare($sql);
  // $stmt->execute();


   // if ($stmt && $stmt->execute() && $stmt->columnCount()> 0) {
   //      while($row = $stmt->fetch()) {
   //   echo " - pic_name: " . $row["pic_name"]. " - pic_likes: " . $row["pic_likes"];
   //   }
   //  }


  //   echo "<br><br>old method: ";
  // $rowCount = $stmt->rowCount();
  // $details = $stmt->fetch();
  // echo 

  // print_r ($details);

    // $sql_query = "SELECT * FROM pictures";
    // $statement = $pdo->prepare($sql_query);
    // if ($statement && $statement->execute() && $statement->columnCount()> 0) {
    //     while($row = $statement->fetch()) {
    //  echo "id: " . $row["id"]. " - pic_name: " . $row["pic_name"]. " - pic_likes: " . $row["pic_likes"];
    //  }
    // } else {
    //     echo 'empty!';
    // }
    // $statement = null;

// $sql = "SELECT * FROM pictures";
// $result = $pdo->query($sql);

// if ($result->num_rows > 0) {
//   // output data of each row
//   while($row = $result->fetch_assoc()) {
//     echo "id: " . $row["id"]. " - pic_name: " . $row["pic_name"]. " - pic_likes: " . $row["pic_likes"]. "<br>";
//   }
// } else {
//   echo "0 results";
// }

// // RETREIVE (for mysqli)
// $stmt = "SELECT * FROM pictures;";
// $result = $pdo->query($stmt);
// while ($row = $result->fetch_assoc()) {
//  echo $row["id"] . $row["pic_name"] . $row["pic_likes"];
// }
}

function connectToDB() {

 $host = "ec2-3-211-221-185.compute-1.amazonaws.com";
$user = "lkyhmxaakgvdzz";
$password = "5c4f13693ff2fec787ea707d97981c064a6d8254bce6a0db009b231c89526760";
$dbname = "d4cqtfhq9c5h0t";
$port = "5432";

try{
  //Set DSN data source name
    $dsn = "pgsql:host=" . $host . ";port=" . $port .";dbname=" . $dbname . ";user=" . $user . ";password=" . $password . ";";


  //create a pdo instance
  $pdo = new PDO($dsn, $user, $password);
  $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
  $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}
catch (PDOException $e) {
echo 'Connection failed: ' . $e->getMessage();
}




//  $params = parse_ini_file("database.ini");
//  if ($params === false) {
//      throw new \Exception("Error while reading database configuration file");
//  }

// $dsn = sprintf("pgsql:host=%s;port=%d;dbname=%s",
//                 $params['host'],
//                 $params['port'],
//                 $params['database'],
//                 );

// try{
//     $conn = new PDO($dsn, $params["username"], $params["password"], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
//     // throw exception upon errors
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// }
// catch (PDOException $e) {
// 	die('Could not connect: ' . $e->getMessage());
// }

}


?>


</body>
</html>