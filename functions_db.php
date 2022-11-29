<?php
function createNewAccount($first_name, $last_name, $password)
{

    // global $db; 
    // $first_query = "SELECT MAX(user_id) FROM user";
    // $first_statement = $db->prepare($first_query);
    // $first_statement->execute();
    // $first_result = $first_statement->fetchAll();   // fetch()
    // $first_statement->closeCursor();

    $query = "INSERT INTO user VALUES (:user_id, :first_name, :last_name, :username; :password)";  
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':user_id', 21);
        $statement->bindValue(':first_name', $first_name);
        $statement->bindValue(':last_name', $last_name);
        $statement->bindValue(':username', $first_name);
        $statement->bindValue(':password', $password);
        $statement->execute();
        $statement->closeCursor();

        // if ($statement->rowCount() == 0)
        //     echo "Failed to add a friend <br/>";
    }
    catch (PDOException $e) 
    {
        // echo $e->getMessage();
        // if there is a specific SQL-related error message
        //    echo "generic message (don't reveal SQL-specific message)";

        if (str_contains($e->getMessage(), "Duplicate"))
		   echo "Failed to create account <br/>";
    }
    catch (Exception $e)
    {
        echo $e->getMessage();
    }
}

// function getAllFriends()
// {
//     global $db; 
//     $query = "SELECT * FROM friends";
//     $statement = $db->prepare($query);
//     $statement->execute();
//     $result = $statement->fetchAll();   // fetch()
//     $statement->closeCursor();
//     return $result;
// }
// 
// function getFriendByName($name)  
// {
//     global $db;
//     $query = "SELECT * FROM friends where name = :name";
// 
//     $statement = $db->prepare($query);
//     $statement->bindValue(':name', $name);
//     $statement->execute();
//     $result = $statement->fetch(); 
//     $statement->closeCursor();    
//     return $result;
// }
// 
// function updateFriend($name, $major, $year)
// {
//     // get instance of PDO
//     // prepare statement
//     //  1) prepare 
//     //  2) bindValue, execute
//     global $db;
//     $query = "UPDATE friends SET major=:major, year=:year WHERE name=:name";
//     $statement = $db->prepare($query);
//     $statement->bindValue(':name', $name);
//     $statement->bindValue(':major', $major);
//     $statement->bindValue(':year', $year);
//     $statement->execute();
//     $statement->closeCursor();
// 
//     // $statement->query()
//     
// 
// 
// 
// }
// 
// function deleteFriend($name)
// {
//     // get instance of PDO
//     // prepare statement
//     //  1) prepare 
//     //  2) bindValue, execute
//     global $db;
//     $query = "DELETE FROM friends WHERE name=:name";
//     $statement = $db->prepare($query);
//     $statement->bindValue(':name', $name);
//     $statement->execute();
//     $statement->closeCursor();
// 
//     // $statement->query()
//     
// 
// 
// 
// }
// 
?>