<?php
require_once './config/config.php';

class Model {
    protected $db;

    public function __construct() {
        $this->db = new PDO(
            "mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DB . ";charset=utf8", 
            MYSQL_USER, MYSQL_PASS
        );
        $this->_deploy();
    }

    private function _deploy() {
        // Crear la tabla categorias
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS categorias (
                id_categoria INT(11) NOT NULL AUTO_INCREMENT,
                nombre_categoria TEXT NOT NULL,
                imagen_url TEXT,
                PRIMARY KEY (id_categoria)
            );
        ");
    
        // Crear la tabla items
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS items (
                id_item INT(11) NOT NULL AUTO_INCREMENT,
                nombre_item TEXT NOT NULL,
                descripcion_item TEXT NOT NULL,
                categoria_id INT(11) NOT NULL,
                imagen_url TEXT,
                PRIMARY KEY (id_item),
                FOREIGN KEY (categoria_id) REFERENCES categorias(id_categoria) 
                ON DELETE CASCADE
            );
        ");
    
        // Crear la tabla clientes
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS clientes (
                id_cliente INT(11) NOT NULL AUTO_INCREMENT,
                nombre_cliente TEXT NOT NULL,
                email_cliente TEXT NOT NULL,
                telefono_cliente TEXT NOT NULL,
                PRIMARY KEY (id_cliente)
            );
        ");
    
        // Crear la tabla reservas
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS reservas (
                id_reserva INT(11) NOT NULL AUTO_INCREMENT,
                fecha_reserva DATE NOT NULL,
                hora_entrada TIME NOT NULL,
                hora_salida TIME NOT NULL,
                id_cliente INT(11) NOT NULL,
                PRIMARY KEY (id_reserva),
                UNIQUE KEY (fecha_reserva),
                FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente)
            );
        ");
    }
    
    

    public function getCategories() {
        $stmt = $this->db->query('SELECT * FROM categorias');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getItemsByCategory($categoryId) {
        $stmt = $this->db->prepare(
            'SELECT items.*, categorias.nombre_categoria 
             FROM items 
             INNER JOIN categorias ON items.categoria_id = categorias.id_categoria
             WHERE categoria_id = :categoria_id'
        );
        $stmt->execute(['categoria_id' => $categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    public function addCategory($name, $image_url = null) {
        $stmt = $this->db->prepare('INSERT INTO categorias (nombre_categoria, imagen_url) VALUES (:nombre, :imagen)');
        $stmt->execute(['nombre' => $name, 'imagen' => $image_url]);
    }
    
    public function updateCategory($id, $name, $image_url = null) {
        $stmt = $this->db->prepare('UPDATE categorias SET nombre_categoria = :nombre, imagen_url = :imagen WHERE id_categoria = :id');
        $stmt->execute(['nombre' => $name, 'imagen' => $image_url, 'id' => $id]);
    }
    
    

    public function deleteCategory($id) {
        $stmt = $this->db->prepare('DELETE FROM categorias WHERE id_categoria = :id');
        $stmt->execute(['id' => $id]);
    }

    public function getCategory($id) {
        $stmt = $this->db->prepare('SELECT * FROM categorias WHERE id_categoria = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
