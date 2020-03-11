<?php


namespace FinalYear;


class DoctrineSqlQueries
{
    public function __construct(){}

    public function __destruct(){}

    public static function queryStoreUserLoginData($queryBuilder, array $cleaned_parameters, string $hashed_password)
    {
        $store_result = [];
        $username = $cleaned_parameters['sanitised_username'];
        $email = $cleaned_parameters['sanitised_email'];
        $role = $cleaned_parameters['role'];

        $queryBuilder = $queryBuilder->insert('users')
            ->values([
                'username' => ':name',
                'email' => ':email',
                'password' => ':password',
                'role' => ':role'
            ])
            ->setParameters([
                ':name' => $username,
                ':email' => $email,
                ':password' => $hashed_password,
                ':role' => $role
            ]);

        $store_result['outcome'] = $queryBuilder->execute();
        $store_result['sql_query'] = $queryBuilder->getSQL();

        return $store_result;
    }

    public static function queryRetrieveUserData()
    {
        $sql_query_string = '';
        return $sql_query_string;
    }
}