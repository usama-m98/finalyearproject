<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;


class DatabaseTest extends TestCase
{

    private $app;
    private $queries;

    public function setUp(): void
    {

        $this->app = new \FinalYear\DatabaseConnection();
        $this->queries = new \FinalYear\DbQueries();

    }

    public function testUserDatabase()
    {


        $this->assertEquals($this->app->sanitiseString('Usama'), 'Usama');

    }
}
