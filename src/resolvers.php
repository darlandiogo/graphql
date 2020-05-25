<?php

require ("database.php");

$env    = parse_ini_file("./.env");
$conn   = new Connection($env);
$db_con = $conn->getConnection();

$users = function( ) use ($db_con){
    $sql = "select * from users;";
    $result = $db_con->query($sql); 
    return $result;
};

$user = function($root, $args) use ($db_con){
    $sql = "select * from users where id = :id ;";
    
    $stm = $db_con->prepare($sql);
    $stm->execute(array("id" => $args['id']));
    $result = $stm->fetchAll();
     
    return $result[0];

};

$addUser = function($root, $args) use ($db_con){
    $sql = "insert into users(name,email) values (:name, :email);";
    $stm = $db_con->prepare($sql);
    $stm->execute([
        'name' => $args['name'],
        'email' => $args['email']
    ]);

    return [
        'id' => $db_con->lastInsertId(),
        'name' => $args['name'],
        'email' => $args['email']
    ];
};

$deleteUser = function($root, $args) use ($db_con){
    $sql = "delete from users where id = :id ;";
    $stm = $db_con->prepare($sql);
    $stm->execute(array("id" => $args['id']));
    return $stm->rowCount();

};


$post = function ( $root, $args) {
    // since id is non-null we can just use it without validation
    return [
        'title' => 'Post title #' . $args['id'],
        'comment' => [
            'content' => 'any text'
        ]
    ];
};