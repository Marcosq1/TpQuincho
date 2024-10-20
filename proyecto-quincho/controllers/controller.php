<?php
require_once 'models/model.php';

class Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new Model();
    }

    public function handleRequest()
    {
        $uri = trim($_SERVER['REQUEST_URI'], '/');
        $parts = explode('/', $uri);

        if (isset($parts[1]) && $parts[1] === 'category' && isset($parts[2])) {
            $this->viewItems($parts[2]); // Ver ítems por categoría
            return;
        }

        $action = $parts[1] ?? 'listCategories'; // Acción por defecto
        switch ($action) {
            case 'listCategories':
                $this->listCategories();
                break;
            case 'login':
                $this->login();
                break;
            case 'logout':
                $this->logout();
                break;
            case 'addCategory':
                $this->checkAuth();
                $this->addCategory();
                break;
            case 'editCategory':
                $this->checkAuth();
                $this->editCategory();
                break;
            case 'deleteCategory':
                $this->checkAuth();
                $this->deleteCategory();
                break;
            default:
                $this->listCategories();
                break;
        }
    }

    private function viewItems($categoryId)
    {
        $items = $this->model->getItemsByCategory($categoryId);
        include 'views/items.php';
    }

    private function listCategories()
    {
        $categories = $this->model->getCategories();
        include 'views/categories.php';
    }

    private function login()
    {
        if ($_POST) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Simulación de contraseña hasheada
            $storedHash = password_hash('admin', PASSWORD_DEFAULT);

            echo "Username: $username<br>"; // Depuración
            echo "Password: $password<br>"; // Depuración

            if ($username === 'webadmin' && password_verify($password, $storedHash)) {
                $_SESSION['logged_in'] = true;
                header('Location: index.php');
                exit;
            } else {
                $error = 'Credenciales incorrectas';
            }
        }
        include 'views/login.php'; // Cargar la vista de login
    }


    private function logout()
    {
        session_destroy();
        header('Location: index.php');
        exit;
    }

    private function addCategory(){
        if ($_POST) {
            $name = $_POST['name'];
            $image_url = $_POST['image_url'] ?? null; // Agregar este campo
            $this->model->addCategory($name, $image_url);
            header('Location: index.php?action=listCategories'); // Redirige a la lista de categorías
            exit; // Asegúrate de incluir exit para detener la ejecución
        }
        include 'views/add_category.php'; // Cargar la vista para agregar categoría
    }


    private function editCategory()
    {
        $categoryId = $_GET['id'];
        if ($_POST) {
            $name = $_POST['name'];
            $image_url = $_POST['image_url'] ?? null; // Agregar este campo
            $this->model->updateCategory($categoryId, $name, $image_url);
            header('Location: index.php?action=listCategories');
            exit;
        }
        $category = $this->model->getCategory($categoryId);
        include 'views/edit_category.php';
    }


    private function deleteCategory()
    {
        $categoryId = $_GET['id'];
        $this->model->deleteCategory($categoryId);
        header('Location: index.php');
        exit;
    }

    private function checkAuth()
    {
        if (empty($_SESSION['logged_in'])) {
            header('Location: index.php?action=login');
            exit;
        }
    }
}
