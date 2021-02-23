<?php

    require('db_credentials.php');

    // Create a function that connects web application to the database
    function db_connect() {
        $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        confirm_db_connect();
        return $connection;
    }

    // Create a function that checks if the web application is connects to the db
    // If there is not a connect the function returns an error message
    function confirm_db_connect() {
        if (mysqli_connect_errno()) {
            $output = "Database connection failed: ";
            $output .= mysqli_connect_error();
            $output .= " (" . mysqli_connect_errno() . ")";
            exit($output);
        }
    }

    // Create a function that add new user to the database
    function add_new_user($connection, $first_name, $last_name, $email, $password) {

        $query = "INSERT INTO users (first_name, last_name, email, password) ";
        $query .= "VALUE ('$first_name', '$last_name', '$email', '$password')";

        if ($connection->query($query) === TRUE) {
            echo "New user created successfully";
        } else {
            echo "Error: " . $query . "<br>" . $connection->error;
        }

    }

    /*
    * Create a function that checks into the db
    *  if an user is already registered
    * by his/her email
    * The function gets a 
    * @parameter $connection that connects to the db and a
    * @parameter $email string that is the user's email and 
    * @return true if the user does not exist
    * otherwise return false
    */
    function is_new_user($connection, $email) {

        $query = "SELECT email FROM users WHERE email='$email'";
        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if ($row['email'] === $email) {
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            return TRUE;
        }

    }

    /*
    * Create a function that check if email and password are associated
    * to an user
    * The function gets 
    * @parameter $connection that connects to the db
    * @parameter $email 
    * @parameter $password 
    * @return boolean true if $email and $password are
    * associated to the user
    * Otherwise return false
    */
    function check_user($connection, $email, $password) {

        $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (($row['email'] === $email) && ($row['password'] === $password)) {
                return TRUE;
            } else {
                return FALSE;
            }

        } else {
            return FALSE;
        }

    }

    /*
    * Create a function that check if email and password are associated
    * to an user
    * and if the user he/she an admin
    * The function gets 
    * @parameter $connection that connects to the db
    * @parameter $email 
    * @parameter $password 
    * @admin $admin
    * @return boolean true if $email, $password and $admin are
    * associated to the admin user
    * Otherwise return false
    */
    function check_admin($connection, $email, $password) {

        $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            

            if (($row['email'] === $email) && ($row['password'] === $password) && ($row['admin'] === "1")) {
                return TRUE;
            } else {
                return FALSE;
            }

        } else {
            return FALSE;
        }

    }

    /*
    * Create a function that gets
    * @parameter $connection that connects to the db
    * @parameter $email of the user and
    * @return string his/her first_name getting it into db
    * This function allows to have the user first_name and stores
    * it on the session
    */
    function get_first_name($connection, $email) {

        $query = "SELECT * FROM users WHERE email='$email'";
        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $first_name = $row['first_name'];
            return $first_name;
        }

    }

    /*
    * Create a function that gets
    * @parameter $connection that connects to the db
    * @parameter $email of the user and
    * @return string his/her last_name getting it into db
    * This function allows to have the user last_name and stores
    * it on the session
    */
    function get_last_name($connection, $email) {

        $query = "SELECT * FROM users WHERE email='$email'";
        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $last_name = $row['last_name'];
            return $last_name;
        }

    }

    /*
    * Create a function that gets
    * @parameter $connection that connects to the db
    * @parameter $email of the user and
    * @return string his/her email getting it into db
    * This function allows to have the user email and stores
    * it on the session
    */
    function get_email($connection, $email) {

        $query = "SELECT * FROM users WHERE email='$email'";
        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $email = $row['email'];
            return $email;
        }

    }

    /*
    * Create a function that gets
    * @parameter $connection that connects to the db
    * @parameter $email of the user and
    * @return string his/her admin permission getting it into db
    * This function allows to have the user admin permission and stores
    * it on the session
    */
    function get_admin_permission($connection, $email) {

        $query = "SELECT * FROM users WHERE email='$email'";
        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $admin = $row['admin'];
            return $admin;
        }

    }

    /*
    * Create a function that gets the users data from the db and 
    * saves it into a variable
    * @parameter $connection that connects to the db
    * @return $result data by the db
    */
    function find_users($connection) {

        $query = "SELECT * FROM users";
        $result = mysqli_query($connection, $query);
        return $result;

    }

    // Create a function that disconnects to the database
    function db_disconnect($connection) {
        if (isset($connection)) {
            mysqli_close($connection);
        }
    }

?>