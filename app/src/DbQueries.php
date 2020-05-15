<?php


namespace FinalYear;


class DbQueries
{
    public function __construct(){}

    public function __destruct(){}

    public function searchQuery()
    {
        $query = 'SELECT product_id, name, type, description, stock, price, product_image ';
        $query .= 'FROM products ';
        $query .= 'WHERE name LIKE :search';

        return $query;
    }

    public function storeUserLoginData()
    {
        $query = "INSERT INTO users";
        $query .= " SET ";
        $query .= "username = :username, ";
        $query .= "email = :email, ";
        $query .= "password = :password, ";
        $query .= "role = :role";

        return $query;
    }

    public function retrieveUserData()
    {
        $query = 'SELECT user_id, username, email, password, role ';
        $query .= 'FROM users ';
        $query .= 'WHERE username = :username';

        return $query;
    }

    public function deleteUser()
    {
        $query = 'DELETE FROM users ';
        $query .= 'WHERE user_id = :user_id';

        return $query;
    }
    public function retrieveAllUserData()
    {
        $query = 'SELECT user_id, username, email, role ';
        $query .= 'FROM users ';

        return $query;
    }

    public function filterUserAndRetrieve()
    {
        $query = 'SELECT user_id, username, email, password, role ';
        $query .= 'FROM users ';
        $query .= 'WHERE role = :role';

        return $query;
    }

    public function updateUsername()
    {
        $query = 'UPDATE users';
        $query .= ' SET ';
        $query .= 'username = :username ';
        $query .= 'WHERE user_id = :user_id';

        return $query;
    }

    public function updateEmail()
    {
        $query = 'UPDATE users';
        $query .= ' SET ';
        $query .= 'email = :email ';
        $query .= 'WHERE user_id = :user_id';

        return $query;
    }

    public function updatePassword()
    {
        $query = 'UPDATE users';
        $query .= ' SET ';
        $query .= 'password = :password ';
        $query .= 'WHERE user_id = :user_id';

        return $query;
    }

    public function updateCustomerDetails()
    {
        $query = 'UPDATE customers';
        $query .= ' SET ';
        $query .= 'firstname = :first_name, surname = :surname, address = :address, ';
        $query .= 'postcode = :postcode, city = :city, phonenumber = :phone_number ';
        $query .= 'WHERE user_id = :userid';

        return $query;
    }

    public function insertPersonalDetails()
    {
        $query = "INSERT INTO customers";
        $query .= " SET ";
        $query .= "firstname = :firstname, ";
        $query .= "surname = :surname, ";
        $query .= "address = :address, ";
        $query .= "postcode = :postcode, ";
        $query .= "city = :city, ";
        $query .= "phonenumber = :phonenumber, ";
        $query .= "user_id = :userid";

        return $query;
    }

    public function retrievePersonalDetails()
    {
        $query = "SELECT customer_id, firstname, surname, address, postcode, city, phonenumber ";
        $query .= "FROM customers ";
        $query .= "WHERE user_id = :user_id";

        return $query;
    }

    public function retrieveProducts()
    {
        $query = 'SELECT product_id, name, type, description, stock, price, product_image ';
        $query .= 'FROM products ';

        return $query;
    }

    public function storeProductData()
    {
        $query = "INSERT INTO products";
        $query .= " SET ";
        $query .= "name = :product_name, ";
        $query .= "type = :product_type, ";
        $query .= "description = :product_description, ";
        $query .= "stock = :product_stock, ";
        $query .= "price = :product_price, ";
        $query .= "product_image = :image";

        return $query;
    }

    public function updateItem()
    {
        $query = "UPDATE products";
        $query .= " SET ";
        $query .= "name = :product_name, ";
        $query .= "type = :product_type, ";
        $query .= "description = :product_description, ";
        $query .= "stock = :product_stock, ";
        $query .= "price = :product_price, ";
        $query .= "product_image = :image ";
        $query .= "WHERE product_id = :product_id";

        return $query;
    }

    public function removeProduct()
    {
        $query = "DELETE FROM products ";
        $query .= "WHERE product_id = :product_id";

        return $query;
    }

    public function updateStock()
    {
        $query = "UPDATE products";
        $query .= " SET ";
        $query .= "stock = :quantity ";
        $query .= "WHERE product_id = :product_id";

        return $query;
    }

    public function storeOrderData()
    {
        $query = "INSERT INTO order_detail";
        $query .= " SET ";
        $query .= "order_date = :date_of_order, ";
        $query .= "description = :description, ";
        $query .= "total = :total, ";
        $query .= "quantity = :quantity, ";
        $query .= "admin_assigned = :assigned, ";
        $query .= "status = :status, ";
        $query .= "customer_id = :customer_id";

        return $query;
    }

    public function retrieveAllOrderData()
    {
        $query = "SELECT o.order_id, o.order_date, o.description, o.total, o.quantity, o.admin_assigned, o.status, o.customer_id, ";
        $query .= " c.address, c.postcode, c.city, c.phonenumber ";
        $query .= "FROM order_detail o, customers c ";
        $query .= "WHERE o.customer_id = c.customer_id";

        return $query;
    }

    public function retrieveAssignedOrderData()
    {
        $query = "SELECT o.order_id, o.order_date, o.description, o.total, o.quantity o.status, o.admin_assigned, o.customer_id, ";
        $query .= "c.address, c.postcode, c.city, c.phonenumber ";
        $query .= "FROM order_detail o, customers c ";
        $query .= "WHERE c.customer_id = o.customer_id AND admin_assigned =:user_id ";

        return $query;
    }

    public function retrieveOrderData()
    {
        $query = "SELECT order_id, order_date, description, total, quantity, status ";
        $query .= "FROM order_detail ";
        $query .= "WHERE customer_id = :customer_id";

        return $query;
    }

    public function retrieveOrderDataToBeAssigned()
    {
        $query = "SELECT order_id, order_date, description, total, quantity, status, customer_id, admin_assigned ";
        $query .= "FROM order_detail ";
        $query .= "WHERE admin_assigned = '1'";

        return $query;
    }

    public function countOfOrdersAssignedToAdmins()
    {
        $query = 'select u.user_id, username, count(o.admin_assigned) AS no_of_assigned ';
        $query .= 'FROM users u, order_detail o ';
        $query .=  'WHERE u.user_id = o.admin_assigned ';
        $query .= 'GROUP BY u.user_id';

        return $query;
    }

    public function reassignAdminAssignment()
    {
        $query = 'UPDATE order_detail';
        $query .= ' SET ';
        $query .= 'admin_assigned = :assignment_value ';
        $query .= 'WHERE order_id = :order_id_value';

        return $query;
    }

    public function updateCancelOrder()
    {
        $query = "UPDATE order_detail";
        $query .= " SET ";
        $query .= "status = :order_status ";
        $query .= "WHERE order_id = :order_id_value";

        return $query;
    }

    public function storeMessage()
    {
        $query = "INSERT INTO messages";
        $query .= " SET ";
        $query .= "message = :message_string, ";
        $query .= "message_state = 'Unread', ";
        $query .= "message_date = :date, ";
        $query .= "order_id = :order_id_value, ";
        $query .= "user_id = :user_id_value";

        return $query;
    }

    public function retrieveAllStoredMessages()
    {
        $query = "SELECT message_id, message, message_state, order_id, user_id ";
        $query .= "FROM messages";

        return $query;
    }

    public function retrieveUserMessages()
    {
        $query = "SELECT message_id, message, message_state, order_id, message_date";
        $query .= "FROM messages ";
        $query .= "WHERE user_id = :user_id_value";
    }
}

