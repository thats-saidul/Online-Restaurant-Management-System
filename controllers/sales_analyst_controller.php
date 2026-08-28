<?php
session_start();

require_once __DIR__ . '/../models/SalesAnalyst.php';

class SalesAnalystController {

    private $model;

    public function __construct() {
        $this->model = new SalesAnalyst();
    }

    /* LOGIN */
    public function login() {
        if (empty($_POST['email']) || empty($_POST['password'])) {
            $_SESSION['login_error'] = "All fields are required.";
            // Redirect to login page
            header("Location: /Restaurant Management System/views/sales_analyst/sales_analyst_login.php");
            exit;
        }

        $user = $this->model->authenticate($_POST['email'], $_POST['password']);

        if ($user) {
            $_SESSION['sales_analyst_id'] = $user['id'];
            $_SESSION['sales_analyst_name'] = $user['fullname'];

            // Redirect to dashboard
            header("Location: /Restaurant Management System/views/sales_analyst/dashboard.php");
            exit;
        } else {
            $_SESSION['login_error'] = "Invalid email or password.";
            header("Location: /Restaurant Management System/views/sales_analyst/sales_analyst_login.php");
            exit;
        }
    }

    /* REGISTER */
    public function register() {
        if ($_POST['password'] !== $_POST['cpassword']) {
            $_SESSION['register_error'] = "Passwords do not match.";
            header("Location: /Restaurant Management System/views/sales_analyst/sales_analyst_register.php");
            exit;
        }

        $this->model->register($_POST);

        // Redirect to login page after successful registration
        header("Location: /Restaurant Management System/views/sales_analyst/sales_analyst_login.php");
        exit;
    }

    /* LOGOUT */
    public function logout() {
        session_destroy();
        header("Location: /Restaurant Management System/views/sales_analyst/sales_analyst_login.php");
        exit;
    }
}

/* ROUTER */
$controller = new SalesAnalystController();
$action = $_GET['action'] ?? '';

if (method_exists($controller, $action)) {
    $controller->$action();
} else {
    die("Invalid action");
}
