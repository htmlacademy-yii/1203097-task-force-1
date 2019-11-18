<?php

use TaskForce\Import\Converter;

require_once 'vendor/autoload.php';

$data = [
    [
        'src' => 'data/categories.csv',
        'dst' => 'categories.sql',
        'table' => 'categories',
        'header' => ['name' => 'text', 'icon' => 'text'],
        'add_fields' => [],
    ],

    [
        'src' => 'data/cities.csv',
        'dst' => 'cities.sql',
        'table' => 'cities',
        'header' => ['city_name' => 'text', 'lat' => 'number', 'lng' => 'number'],
        'add_fields' => [],
    ],

    [
        'src' => 'data/users.csv',
        'dst' => 'users.sql',
        'table' => 'users',
        'header' => ['email' => 'text', 'name' => 'text', 'password' => 'text', 'created_at' => 'text'],
        'add_fields' => [],
    ],

    [
        'src' => 'data/profiles.csv',
        'dst' => 'user_profiles.sql',
        'table' => 'user_profiles',
        'header' => ['address' => 'text', 'birthday' => 'text', 'information' => 'text', 'contact_phone' => 'text', 'contact_skype' => 'text'],
        'add_fields' =>
            [
                ['field_name' => 'user_id', 'field_type' => 'number', 'random' => [1, 20]],
                ['field_name' => 'city_id', 'field_type' => 'number', 'random' => [1, 1108]],
            ]
    ],

    [
        'src' => 'data/tasks.csv',
        'dst' => 'tasks.sql',
        'table' => 'tasks',
        'header' =>
            [
                'created_at' => 'text', 'category_id' => 'number', 'description' => 'text',
                'date_close' => 'text', 'name' => 'text', 'address' => 'text', 'budget' => 'number',
                'lat' => 'number', 'lng' => 'number'
            ],
        'add_fields' =>
            [
                ['field_name' => 'status', 'field_type' => 'text', 'random' => ['new', 'processing', 'cancelled', 'completed', 'failed']],
                ['field_name' => 'owner_user_id', 'field_type' => 'number', 'random' => [1, 20]],
                ['field_name' => 'performer_user_id', 'field_type' => 'number', 'random' => [1, 20]],
                ['field_name' => 'city_id', 'field_type' => 'number', 'random' => [1, 1108]],
            ]
    ],

    [
        'src' => 'data/opinions.csv',
        'dst' => 'reviews.sql',
        'table' => 'reviews',
        'header' => ['created_at' => 'text', 'score' => 'number', 'message' => 'text'],
        'add_fields' =>
            [
                ['field_name' => 'task_id', 'field_type' => 'number', 'random' => [1, 10]],
                ['field_name' => 'owner_id', 'field_type' => 'number', 'random' => [1, 20]],
                ['field_name' => 'performer_id', 'field_type' => 'number', 'random' => [1, 20]],
                ['field_name' => 'task_completed', 'field_type' => 'number', 'random' => [0, 1]],
            ]
    ],

    [
        'src' => 'data/replies.csv',
        'dst' => 'responses.sql',
        'table' => 'responses',
        'header' => ['created_at' => 'text', 'task_id' => 'number', 'comment' => 'text'],
        'add_fields' =>
            [
                ['field_name' => 'user_id', 'field_type' => 'number', 'random' => [1, 20]],
                ['field_name' => 'price', 'field_type' => 'number', 'random' => [1, 10000]],
            ]
    ],

];

foreach ($data as $instance) {
    $converter = new Converter($instance['src'], $instance['dst'], $instance['table'], $instance['header'], $instance['add_fields']);
    $converter->convert();
}
