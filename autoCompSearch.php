<?php 
  /*Detta försök har övergivits.
  Jag hittade ett exempel på internet, men jag gick vidare och la energi på auto complete
  som använder datalist och ajax(?) (json-datalist.js)*/

  $loginMySQL = mysqli_connect("localhost", "HansKristoff", "hanskris112", "biografen");
  if (mysqli_connect_errno())
  {
    echo "Något gick fel: " . mysqli_connect_error();
  }

  type = 0;
  if (isset($_POST['type']))
  {
    $type = $_POST['type'];
  }
 //ORDER BY FirstName ASC LIMIT 5"
  if ($type == 1)
  {
    $searchText = mysqli_real_escape_string($loginMySQL, $_POST['serach']);
    $searchSQL = "SELECT CustomerID, FirstName FROM `customers` WHERE FirstName LIKE '%" . $searchText . "%'";
    $searchResult = mysqli_query($loginMySQL, $searchSQL);

    $search_arr = array();

    while ($getSearch = mysqli_fetch_assoc($searchResult))
    {
      $customerID = $getSearch['CustomerID'];
      $firstName = $getSearch['FirstName'];

      $search_arr[] = array("customerID" => $customerID, "firstName" => $firstName);
    }
    echo json_encode($search_arr);
  }
  if ($type == 2)
  {
    $userID = mysqli_real_escape_string($loginMySQL, $_POST['userID']);
    $getCustomerSQL = "SELECT FirstName, LastName, Email, Phone FROM `customers` WHERE CustomerID = '$userID' ";
    $getCustomerResult = mysqli_query($loginMySQL, $getCustomerSQL);

    $return_arr = array();
    while ($getCustomer = mysqli_fetch_assoc($getCustomerResult))
    {
      $fullName = $getCustomer['FirstName'], " ", $getCustomer['LastName'];
      $email = $getCustomer['Email'];
      $phone = $getCustomer['Phone'];

      $return_arr[] = array("fullName" => $fullName, "email" => $email, "phone" => $phone);
    }
    echo json_encode($return_arr);
  }
?>
