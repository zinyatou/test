
//fetch_single.php
<?php
include('db.php');
include('function.php');
if(isset($_POST["member_id"]))
{
    $output = array();
    $statement = $connection->prepare(
        "SELECT * FROM member WHERE id = '".$_POST["member_id"]."' LIMIT 1"
    );
    $statement->execute();
    $result = $statement->fetchAll();
    foreach($result as $row)
    {
        $output["id"] = $row["id"];
        $output["name"] = $row["name"];
        $output["category"] = $row["category"];

    }
    echo json_encode($output);
}
?>