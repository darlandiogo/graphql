<?php

require __DIR__ ."/vendor/autoload.php";
require __DIR__ ."/src/Types.php";
require __DIR__ ."/src/resolvers.php";

use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

$queryType = new ObjectType([
    'name' => 'Query',
    'fields' => [
        'users' => [
            'type' => Type::listOf($userType),
            'resolve' => $users
        ],
        'user' => [
            'type' => $userType, 
            'args' => [
               'id' => Type::nonNull(Type::int()),
            ],
            'resolve' => $user
        ],
        'post' => [
            'type'    => $postType,
            'args'    => [
                'id' => Type::nonNull(Type::int()),
            ],
            'resolve' => $post
        ], 
    ],
]);

$mutationType = new ObjectType([
    'name' => 'Mutation',
    'fields' => [
        'addUser' => [
            'type' => $userType,
            'args' => [
                'name' => Type::nonNull(Type::string()),
                'email' => Type::nonNull(Type::string()),
            ],
            'resolve' => $addUser
        ],
        'deleteUser' => [
            'type' => Type::int(), 
            'args' => [
               'id' => Type::nonNull(Type::int()),
            ],
            'resolve' => $deleteUser
        ],
    ],
]);

$schema = new Schema([
    'query' => $queryType,
    'mutation' => $mutationType
]);

$rawInput = file_get_contents('php://input');
$input = json_decode($rawInput, true);
$query = $input['query'];

$variableValues = isset($input['variables']) ? $input['variables'] : null;

try {
    $rootValue = null;
    $result = GraphQL::executeQuery($schema, $query, $rootValue, null, $variableValues);
    $output = $result->toArray();
} catch (\Exception $e) {
    $output = [
        'errors' => [
            [
                'message' => $e->getMessage()
            ]
        ]
    ];
}

header('Content-Type: application/json');
echo json_encode($output);

