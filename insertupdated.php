//insertupdated.php
<?php
include('db.php');
include('function.php');
if(isset($_POST["operation"]))
{
    if($_POST["operation"] == "Add")
    {
        $statement = $connection->prepare("
            INSERT INTO member (name, category) VALUES (:name, :category)");
        $result = $statement->execute(
            array(
                ':name' =>   $_POST["name"],
                ':category'    =>   $_POST["category"],
            )
        );
    }
    if($_POST["operation"] == "Edit")
    {
        $statement = $connection->prepare(
            "UPDATE member
            SET name = :name, category = :category WHERE id = :id");
        $result = $statement->execute(
            array(
                ':name' =>   $_POST["name"],
                ':category'    =>   $_POST["category"],
                ':id'           =>   $_POST["member_id"]
            )
        );
    }
}
?>