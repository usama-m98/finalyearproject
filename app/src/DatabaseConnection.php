<?php


namespace FinalYear;
use PDO;

class DatabaseConnection
{
    private $db_handle;
    private $prepared_statement;
    private $errors;

    public function __construct()
    {
        $this->db_handle = null;
        $this->prepared_statement = null;
        $this->errors = [];
    }

    public function __destruct() { }


    public function makeDatabaseConnection()
    {
        $pdo_error = '';

        $host_details = 'mysql:host=localhost;port=3306;dbname=final_year_db';
        $user_name = 'final_year_user';
        $user_password = 'final_year_pass';
        $pdo_attributes = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => true,
            ];

        try
        {
            $pdo_handle = new \PDO($host_details, $user_name, $user_password, $pdo_attributes);
            $this->db_handle = $pdo_handle;
        }
        catch (\PDOException $exception_object)
        {
            trigger_error('error connecting to database');
            $pdo_error = 'error connecting to database';
        }

        return $pdo_error;
    }


    /**
     * @param $query_string
     * @param null $params
     *
     * For transparency, each parameter value is bound separately to its placeholder
     * This is not always strictly necessary.
     *
     * @return mixed
     */
    public function query($query_string, $params = null)
    {
        $this->errors['failed'] = false;
        $query_parameters = $params;

        try
        {
            $this->prepared_statement = $this->db_handle->prepare($query_string);
            $execute_result = $this->prepared_statement->execute($query_parameters);
            $this->errors['execute-OK'] = $execute_result;
        }
        catch (PDOException $exception_object)
        {
            var_dump('Database Error');
            $this->errors['failed'] = true;
        }
        return $this->errors['failed'];
    }

    public function countRows()
    {
        $num_rows = $this->prepared_statement->rowCount();
        return $num_rows;
    }

    public function safeFetchRow()
    {
        $record_set = $this->prepared_statement->fetch(\PDO::FETCH_NUM);
        return $record_set;
    }

    public function safeFetchArray()
    {
        $arr_row = $this->prepared_statement->fetch(\PDO::FETCH_ASSOC);
        return $arr_row;
    }

    public function lastInsertedID()
    {
        $sql_query = 'SELECT LAST_INSERT_ID()';

        $this->safeQuery($sql_query);
        $arr_last_inserted_id = $this->safeFetchArray();
        $last_inserted_id = $arr_last_inserted_id['LAST_INSERT_ID()'];
        return $last_inserted_id;
    }

    public function safeFetchAll()
    {
        $row = $this->prepared_statement->fetchAll();
        return $row;
    }
}
