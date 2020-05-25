<?php

return [
    'userManagement' => [
        'title'          => 'User management',
        'title_singular' => 'User management',
    ],
    'permission'     => [
        'title'          => 'Permissions',
        'title_singular' => 'Permission',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'title'             => 'Title',
            'title_helper'      => '',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'role'           => [
        'title'          => 'Roles',
        'title_singular' => 'Role',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => '',
            'title'              => 'Title',
            'title_helper'       => '',
            'permissions'        => 'Permissions',
            'permissions_helper' => '',
            'created_at'         => 'Created at',
            'created_at_helper'  => '',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => '',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => '',
        ],
    ],
    'user'           => [
        'title'          => 'Users',
        'title_singular' => 'User',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => '',
            'name'                     => 'Name',
            'name_helper'              => '',
            'email'                    => 'Email',
            'email_helper'             => '',
            'email_verified_at'        => 'Email verified at',
            'email_verified_at_helper' => '',
            'password'                 => 'Password',
            'password_helper'          => '',
            'roles'                    => 'Roles',
            'roles_helper'             => '',
            'remember_token'           => 'Remember Token',
            'remember_token_helper'    => '',
            'created_at'               => 'Created at',
            'created_at_helper'        => '',
            'updated_at'               => 'Updated at',
            'updated_at_helper'        => '',
            'deleted_at'               => 'Deleted at',
            'deleted_at_helper'        => '',
        ],
    ],
    'player'           => [
        'title'          => 'Players',
        'title_singular' => 'Player',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => '',
            'email'                    => 'Email',
            'email_helper'             => '',
            'password'                 => 'Password',
            'password_helper'          => '',
            'first_name'               => 'First Name',
            'first_name_helper'        => '',
            'last_name'                => 'Last Name',
            'last_name_helper'         => '',
            'birthday'                 => 'Birthday',
            'birthday_helper'          => '',
            'photo'                    => 'Photo',
            'photo_helper'             => '',
            'credits'                  => 'Credits',
            'credits_helper'           => '',
            'created_at'               => 'Created at',
            'created_at_helper'        => '',
            'updated_at'               => 'Updated at',
            'updated_at_helper'        => '',
            'deleted_at'               => 'Deleted at',
            'deleted_at_helper'        => '',
        ],
    ],
    'category'       => [
        'title'          => 'Categories',
        'title_singular' => 'Category',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'name'              => 'Name',
            'name_helper'       => '',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'shop'           => [
        'title'          => 'Shops',
        'title_singular' => 'Shop',
        'fields'         => [
            'id'                   => 'ID',
            'id_helper'            => '',
            'name'                 => 'Name',
            'name_helper'          => '',
            'categories'           => 'Categories',
            'categories_helper'    => '',
            'description'          => 'Description',
            'description_helper'   => '',
            'photos'               => 'Photos',
            'photos_helper'        => '',
            'address'              => 'Address',
            'address_helper'       => '',
            'active'               => 'Active',
            'active_helper'        => '',
            'working_hours'        => 'Working Hours',
            'working_hours_helper' => '',
            'created_at'           => 'Created at',
            'created_at_helper'    => '',
            'updated_at'           => 'Updated at',
            'updated_at_helper'    => '',
            'deleted_at'           => 'Deleted at',
            'deleted_at_helper'    => '',
            'created_by'           => 'Created By',
            'created_by_helper'    => '',
        ],
    ],
    'match'       => [
        'title'          => 'Matches',
        'title_singular' => 'Match',
        'fields'         => [
            'id'                   => 'ID',
            'id_helper'            => '',
            'host_name'            => 'Host Name',
            'host_name_helper'     => '',
            'host_photo'           => 'Host Photo',
            'host_photo_helper'    => '',
            'title'                => 'Title',
            'title_helper'         => '',
            'start_time'           => 'Date time',
            'start_time_helper'    => '',
            'description'          => 'Description',
            'description_helper'   => '',
            'photos'               => 'Photos',
            'photos_helper'        => '',
            'address'              => 'Location',
            'address_helper'       => '',
            'rules'              => 'Rules',
            'rules_helper'       => '',
            'players'              => 'Players',
            'players_helper'       => '',
            'active'               => 'Active',
            'active_helper'        => '',
            'working_hours'        => 'Working Hours',
            'working_hours_helper' => '',
            'created_at'           => 'Created at',
            'created_at_helper'    => '',
            'updated_at'           => 'Updated at',
            'updated_at_helper'    => '',
            'deleted_at'           => 'Deleted at',
            'deleted_at_helper'    => '',
            'created_by'           => 'Created By',
            'created_by_helper'    => '',
        ],
    ],
    'booking'       => [
        'title'          => 'Bookings',
        'title_singular' => 'Booking',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'match_id'              => 'Match ID',
            'match_id_helper'       => '',
            'player_id'              => 'Player ID',
            'player_id_helper'       => '',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
];
