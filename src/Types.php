<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

$userType = new ObjectType([
    "name" => 'User',
    "fields" => [
        "id" => Type::int(),
        "name" => Type::string(),
        "email" => Type::string()
    ],
]); 

$commentType = new ObjectType([
    'name'   => 'Comment',
    'fields' => [
        'content' => Type::string(),
    ]
]);

$postType = new ObjectType([
    'name'   => 'Post',
    'fields' => [
        'title' => Type::string(),
        'comment'  => $commentType,  
    ]
]);