<?php
require_once '../Database/dbconnection.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Start transaction
        $pdo->beginTransaction();

        // Insert product data
        $stmt = $pdo->prepare("
            INSERT INTO products 
            (category, product_name, description, price, material, quantity, tags) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        
        $stmt->execute([
            $_POST['category'],
            $_POST['productName'],
            $_POST['description'],
            $_POST['price'],
            $_POST['material'],
            $_POST['quantity'],
            $_POST['tags'] ?? null
        ]);
        
        $productId = $pdo->lastInsertId();

        // Insert sizes
        if (isset($_POST['sizes'])) {
            $sizeStmt = $pdo->prepare("INSERT INTO product_sizes (product_id, size) VALUES (?, ?)");
            foreach ($_POST['sizes'] as $size) {
                $sizeStmt->execute([$productId, $size]);
            }
        }

        // Handle image uploads
        if (!empty($_FILES['productImages']['name'][0])) {
            // Create product_image directory if it doesn't exist
            if (!file_exists('../product_image')) {
                mkdir('../product_image', 0777, true);
            }

            $imageStmt = $pdo->prepare("INSERT INTO product_images (product_id, image_path) VALUES (?, ?)");
            
            foreach ($_FILES['productImages']['tmp_name'] as $key => $tmpName) {
                $fileName = uniqid() . '_' . basename($_FILES['productImages']['name'][$key]);
                $targetPath = '../product_image/' . $fileName;
                
                if (move_uploaded_file($tmpName, $targetPath)) {
                    $imageStmt->execute([$productId, 'product_image/' . $fileName]);
                } else {
                    throw new Exception("Failed to upload image: " . $_FILES['productImages']['name'][$key]);
                }
            }
        }

        // Commit transaction
        $pdo->commit();
        
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        // Rollback transaction on error
        $pdo->rollBack();
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
}
?>