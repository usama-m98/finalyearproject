<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;


class DatabaseTest extends TestCase
{

    private $database;
    private $queries;

    public function setUp(): void
    {

        $this->database = new \FinalYear\DatabaseConnection();
        $this->queries = new \FinalYear\DbQueries();
        $this->database->makeDatabaseConnection();
    }

    public function testUserDatabase()
    {
        $store_login = $this->queries->storeUserLoginData();
        $retrieve_user = $this->queries->retrieveUserData();
        $delete_user = $this->queries->deleteUser();
        $all_users = $this->queries->retrieveAllUserData();
        $filter_user = $this->queries->filterUserAndRetrieve();
        $update_username = $this->queries->updateUsername();
        $update_email = $this->queries->updateEmail();
        $update_password = $this->queries->updatePassword();

        $parameter = [
            'login' => [
                ':username' => 'usama',
                ':email' => 'usama2051@gmail.com',
                ':password' => '$2y$12$HR0eKZx1eEkIQMmnPTH25OqeE8gs0Tewt1bmfmoj4VZwjWmtecrTy',
                ':role' => 'Member'
            ],
            'retrieve_user' => [':username' => 'usama'],
            'delete_user' => [':user_id' =>'5'],
            'filter_user' => [':role' => 'Member'],
            'username' => [
                ':username' => 'ahmed',
                ':user_id' => '5'
            ],
            'email' => [
                ':email' => 'usama345@gmail.com',
                ':user_id' => '5'
            ],
            'password' => [
              ':password' =>  '$2y$12$HR0eKZx1eEkIQMmnPTH25OqeE8gs0Tewt1bmfmoj4VZwjWmtecrTy',
                ':user_id' => '5'
            ],
        ];

        $this->assertFalse($this->database->query($store_login, $parameter['login']));
        $this->assertFalse($this->database->query($retrieve_user, $parameter['retrieve_user']));
        $this->assertFalse($this->database->query($delete_user, $parameter['delete_user']));
        $this->assertFalse($this->database->query($all_users));
        $this->assertFalse($this->database->query($filter_user, $parameter['filter_user']));
        $this->assertFalse($this->database->query($update_username, $parameter['username']));
        $this->assertFalse($this->database->query($update_email, $parameter['email']));
        $this->assertFalse($this->database->query($update_password, $parameter['password']));

    }
}
