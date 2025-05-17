<?php
require_once '../Database/dbconnection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../view-products.php');
    exit;
}

$response = ['success' => false, 'message' => ''];

try {
    $pdo->beginTransaction();
    
    // Update product info
    $stmt = $pdo->prepare("
        UPDATE products SET 
            category = ?,
            product_name = ?,
            description = ?,
            price = ?,
            material = ?,
            quantity = ?,
            tags = ?
        WHERE product_id = ?
    ");
    
    $stmt->execute([
        $_POST['category'],
        $_POST['productName'],
        $_POST['description'],
        $_POST['price'],
        $_POST['material'],
        $_POST['quantity'],
        $_POST['tags'] ?? null,
        $_POST['product_id']
    ]);
    
    // Handle sizes
    $pdo->prepare("DELETE FROM product_sizes WHERE product_id = ?")
        ->execute([$_POST['product_id']]);
    
    if (!empty($_POST['sizes'])) {
        $sizeStmt = $pdo->prepare("INSERT INTO product_sizes (product_id, size) VALUES (?, ?)");
        foreach ($_POST['sizes'] as $size) {
            $sizeStmt->execute([$_POST['product_id'], $size]);
        }
    }
    
    // Handle images
    $existingImages = $_POST['existing_images'] ?? [];
    $removedImages = $_POST['removed_images'] ?? [];
    
    // Delete removed images from database and filesystem
    foreach ($removedImages as $image) {
        $filePath = "../$image";
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        $pdo->prepare("DELETE FROM product_images WHERE image_path = ? AND product_id = ?")
            ->execute([$image, $_POST['product_id']]);
    }
    
    // Handle new image uploads
    if (!empty($_FILES['productImages']['name'][0])) {
        $uploadDir = '../product_image/'; // Changed to your existing folder
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        foreach ($_FILES['productImages']['tmp_name'] as $key => $tmpName) {
            if ($_FILES['productImages']['error'][$key] === UPLOAD_ERR_OK) {
                $fileName = uniqid() . '_' . basename($_FILES['productImages']['name'][$key]);
                $targetPath = $uploadDir . $fileName;
                
                if (move_uploaded_file($tmpName, $targetPath)) {
                    $pdo->prepare("INSERT INTO product_images (product_id, image_path) VALUES (?, ?)")
                        ->execute([$_POST['product_id'], "product_image/$fileName"]); // Updated path
                }
            }
        }
    }
    
    $pdo->commit();
    $response = ['success' => true, 'message' => 'Product updated successfully'];
    
} catch (PDOException $e) {
    $pdo->rollBack();
    $response = ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
} catch (Exception $e) {
    $response = ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
}

header('Content-Type: application/json');
echo json_encode($response);