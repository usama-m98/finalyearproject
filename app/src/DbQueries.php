<?php


namespace FinalYear;


class DbQueries
{
    public function __construct(){}

    public function __destruct(){}

    public function storeUserLoginData()
    {
        $query_string = "INSERT INTO users";
        $query_string .= " SET ";
        $query_string .= "username = :username, ";
        $query_string .= "email = :email, ";
        $query_string .= "password = :password, ";
        $query_string .= "role = :role";

        return $query_string;
    }

    public function retrieveUserData()
    {
        $query_string = 'SELECT user_id, username, email, password, role ';
        $query_string .= 'FROM users ';
        $query_string .= 'WHERE username = :username';

        return $query_string;
    }

    public function retrieveAllUserData()
    {
        $query_string = 'SELECT user_id, username, email, role ';
        $query_string .= 'FROM users ';

        return $query_string;
    }

    public function filterUserAndRetrieve()
    {
        $query_string = 'SELECT user_id, username, email, password, role ';
        $query_string .= 'FROM users ';
        $query_string .= 'WHERE role = :role';

        return $query_string;
    }

    public function updateUsername()
    {
        $query_string = 'UPDATE users';
        $query_string .= ' SET ';
        $query_string .= 'username = :username ';
        $query_string .= 'WHERE user_id = :user_id';

        return $query_string;
    }

    public function updateEmail()
    {
        $query_string = 'UPDATE users';
        $query_string .= ' SET ';
        $query_string .= 'email = :email ';
        $query_string .= 'WHERE user_id = :user_id';

        return $query_string;
    }

    public function updatePassword()
    {
        $query_string = 'UPDATE users';
        $query_string .= ' SET ';
        $query_string .= 'password = :password ';
        $query_string .= 'WHERE user_id = :user_id';

        return $query_string;
    }


    public function insertPersonalDetails()
    {
        $query_string = "INSERT INTO customers";
        $query_string .= " SET ";
        $query_string .= "first_name = :firstname, ";
        $query_string .= "surname = :surname, ";
        $query_string .= "address = :address, ";
        $query_string .= "postcode = :postcode, ";
        $query_string .= "city = :city, ";
        $query_string .= "phone_number = :phonenumber, ";
        $query_string .= "user_id = :userid";

        return $query_string;
    }

    public function retrievePersonalDetails()
    {
        $query_string = "SELECT customer_id, first_name, surname, address, postcode, city, phone_number ";
        $query_string .= "FROM customers ";
        $query_string .= "WHERE user_id = :user_id";

        return $query_string;
    }

    public function retrieveProducts()
    {
        $query_string = 'SELECT product_id, name, type, description, stock, price, product_image ';
        $query_string .= 'FROM products ';

        return $query_string;
    }

    public function storeProductData()
    {
        $query_string = "INSERT INTO products";
        $query_string .= " SET ";
        $query_string .= "name = :product_name, ";
        $query_string .= "type = :product_type, ";
        $query_string .= "description = :product_description, ";
        $query_string .= "stock = :product_stock, ";
        $query_string .= "price = :product_price, ";
        $query_string .= "product_image = :image";

        return $query_string;
    }

    public function updateItem()
    {
        $query_string = "UPDATE products";
        $query_string .= " SET ";
        $query_string .= "name = :product_name, ";
        $query_string .= "type = :product_type, ";
        $query_string .= "description = :product_description, ";
        $query_string .= "stock = :product_stock, ";
        $query_string .= "price = :product_price, ";
        $query_string .= "product_image = :image ";
        $query_string .= "WHERE product_id = :product_id";

        return $query_string;
    }

    public function removeProduct()
    {
        $query_string = "DELETE FROM products ";
        $query_string .= "WHERE product_id = :product_id";

        return $query_string;
    }

    public function updateStock()
    {
        $query_string = "UPDATE products";
        $query_string .= " SET ";
        $query_string .= "stock = :quantity ";
        $query_string .= "WHERE product_id = :product_id";

        return $query_string;
    }

    public function storeOrderData()
    {
        $query_string = "INSERT INTO order_detail";
        $query_string .= " SET ";
        $query_string .= "order_date = :date_of_order, ";
        $query_string .= "description = :description, ";
        $query_string .= "total = :total, ";
        $query_string .= "address = :address, ";
        $query_string .= "postcode = :postcode, ";
        $query_string .= "city = :city, ";
        $query_string .= "admin_assigned = :assigned, ";
        $query_string .= "status = :status, ";
        $query_string .= "customer_id = :customer_id";

        return $query_string;
    }

    public function retrieveAllOrderData()
    {
        $query_string = "SELECT order_id, order_date, description, total, address, postcode, city, admin_assigned, status, customer_id ";
        $query_string .= "FROM order_detail ";

        return $query_string;
    }

    public function retrieveAssignedOrderData()
    {
        $query_string = "SELECT order_id, order_date, description, total, address, postcode, city, status, admin_assigned, customer_id ";
        $query_string .= "FROM order_detail ";
        $query_string .= "WHERE admin_assigned = :user_id";

        return $query_string;
    }

    public function retrieveOrderData()
    {
        $query_string = "SELECT order_id, order_date, description, total, status ";
        $query_string .= "FROM order_detail ";
        $query_string .= "WHERE customer_id = :customer_id";

        return $query_string;
    }

    public function retrieveOrderDataToBeAssigned()
    {
        $query_string = "SELECT order_id, order_date, description, total, status, customer_id,   admin_assigned ";
        $query_string .= "FROM order_detail ";
        $query_string .= "WHERE admin_assigned = '1'";

        return $query_string;
    }

    public function countOfOrdersAssignedToAdmins()
    {
        $query_string = 'select u.user_id, username, count(o.admin_assigned) AS no_of_assigned ';
        $query_string .= 'FROM users u, order_detail o ';
        $query_string .=  'WHERE u.user_id = o.admin_assigned ';
        $query_string .= 'GROUP BY u.user_id';

        return $query_string;
    }

    public function reassignAdminAssignment()
    {
        $query_string = 'UPDATE order_detail';
        $query_string .= ' SET ';
        $query_string .= 'admin_assigned = :assignment_value ';
        $query_string .= 'WHERE order_id = :order_id_value';

        return $query_string;
    }

    public function updateCancelOrder()
    {
        $query_string = "UPDATE order_detail";
        $query_string .= " SET ";
        $query_string .= "status = :order_status ";
        $query_string .= "WHERE order_id = :order_id_value";

        return $query_string;
    }

    public function storeMessage()
    {
        $query_string = "INSERT INTO messages";
        $query_string .= " SET ";
        $query_string .= "message = :message_string, ";
        $query_string .= "message_state = 'Unread', ";
        $query_string .= "message_date = :date, ";
        $query_string .= "order_id = :order_id_value, ";
        $query_string .= "user_id = :user_id_value";

        return $query_string;
    }

    public function retrieveAllStoredMessages()
    {
        $query_string = "SELECT message_id, message, message_state, order_id, user_id ";
        $query_string .= "FROM messages";

        return $query_string;
    }

    public function retrieveUserMessages()
    {
        $query_string = "SELECT message_id, message, message_state, order_id, message_date";
        $query_string .= "FROM messages ";
        $query_string .= "WHERE user_id = :user_id_value";
    }
}

