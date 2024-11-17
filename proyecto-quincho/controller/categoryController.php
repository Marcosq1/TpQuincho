<?php
require_once '../config/database.php';
require_once '../models/categoryModel.php';

$categoryModel = new CategoryModel($pdo);

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
$resource = array_shift($request);
$id = array_shift($request);

if ($resource === 'categories') {
    switch ($method) {
        case 'GET':
            if ($id) {
                $category = $categoryModel->getCategoryById($id);
                if ($category) {
                    echo json_encode($category);
                } else {
                    http_response_code(404);
                    echo json_encode(['error' => 'Categoría no encontrada']);
                }
            } else {
                echo json_encode($categoryModel->getAllCategories());
            }
            break;
        case 'POST':
            $input = json_decode(file_get_contents('php://input'), true);
            if (isset($input['name'])) {
                $newId = $categoryModel->createCategory($input['name']);
                http_response_code(201);
                echo json_encode(['id' => $newId]);
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'Nombre de categoría requerido']);
            }
            break;
        case 'PUT':
            $input = json_decode(file_get_contents('php://input'), true);
            if ($id && isset($input['name'])) {
                $rows = $categoryModel->updateCategory($id, $input['name']);
                if ($rows > 0) {
                    echo json_encode(['success' => 'Categoría actualizada']);
                } else {
                    http_response_code(404);
                    echo json_encode(['error' => 'Categoría no encontrada']);
                }
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'ID y nombre de categoría requeridos']);
            }
            break;
        default:
            http_response_code(405);
            echo json_encode(['error' => 'Método no permitido']);
    }
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Recurso no encontrado']);
}
?>
