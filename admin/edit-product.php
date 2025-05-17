<?php
require_once '../Database/dbconnection.php';

if (!isset($_GET['id'])) {
    header('Location: view-products.php');
    exit;
}

$productId = $_GET['id'];

// Fetch product data
$product = [];
$sizes = [];
$images = [];

try {
    // Get product info
    $stmt = $pdo->prepare("SELECT * FROM products WHERE product_id = ?");
    $stmt->execute([$productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$product) {
        header('Location: view-products.php');
        exit;
    }
    
    // Get sizes
    $stmt = $pdo->prepare("SELECT size FROM product_sizes WHERE product_id = ?");
    $stmt->execute([$productId]);
    $sizes = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    // Get images
    $stmt = $pdo->prepare("SELECT image_path FROM product_images WHERE product_id = ?");
    $stmt->execute([$productId]);
    $images = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
} catch (PDOException $e) {
    // Handle error
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <!-- STYLES -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.16.1/sweetalert2.all.min.js" integrity="sha512-xY6WH58rPXt0+5LumlzGmgubLDO+SnuAqjBRO6i1B0VTFFSZR/aXszP6xjdT431rS24D8ztDPVjVPHb3Se9f6Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../styles/edit-product.css">
</head>
<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="#" class="brand">
            <img src="../dept.png" alt="Logo">
            <span class="text">UniHub</span>
        </a>
        <ul class="side-menu-top">
            <li class="active">
                <a href="dashboard.php">
                    <i class="bx bxs-dashboard"></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="users.php">
                    <i class="bx bxs-user"></i>
                    <span class="text">Users</span>
                </a>
            </li>
            <li>
                <a href="view-products.php">
                    <i class="bx bxs-box"></i>
                    <span class="text">View Products</span>
                </a>
            </li>
            <li>
                <a href="add-products.php">
                    <i class="bx bxs-plus-circle"></i>
                    <span class="text">Add Products</span>
                </a>
            </li>
            <li>
                <a href="Messages.php">
                    <i class="bx bxs-message"></i>
                    <span class="text">Messages</span>
                </a>
            </li>
            <li>
                <a href="orders.php">
                    <i class="bx bxs-shopping-bag"></i>
                    <span class="text">Orders</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu-bottom">
            <li>
                <a href="archive.php">
                    <i class="bx bxs-archive"></i>
                    <span class="text">Archive</span>
                </a>
            </li>
            <li>
                <a href="logout.php">
                    <i class="bx bxs-log-out"></i>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
    </section>

    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <i class="bx bx-menu toggle-sidebar"></i>
            <a href="#" class="nav-link">Categories</a>
            <form action="#">
                <div class="form-input">
                    <input type="search" placeholder="Search...">
                    <button type="submit" class="search-btn"><i class="bx bx-search"></i></button>
                </div>
            </form>
            <a href="#" class="notification">
                <i class="bx bxs-bell"></i>
                <span class="num">99+</span>
            </a>
            <a href="#" class="profile">
                <img src="">
            </a>
        </nav>

        <!-- MAIN -->
      <main>
    <div class="head-title">
        <div class="left">
            <h1>Edit Product</h1>
            <ul class="breadcrumb">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li><a href="view-products.php">View Products</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li><a class="active" href="#">Edit Product</a></li>
            </ul>
        </div>
    </div>

    <div class="add-product-form">
        <div class="form-container">
            <form id="productForm" enctype="multipart/form-data" action="../actions/update_product.php" method="POST">
                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                
                <div class="ap-form-group">
                    <label for="category">Category</label>
                    <select id="category" name="category" required>
                        <option value="">Select a category</option>
                        <option value="dept_shirt" <?= $product['category'] == 'dept_shirt' ? 'selected' : '' ?>>Dept. Shirt</option>
                        <option value="college_uniform" <?= $product['category'] == 'college_uniform' ? 'selected' : '' ?>>College Uniform</option>
                        <option value="pe_uniform" <?= $product['category'] == 'pe_uniform' ? 'selected' : '' ?>>P.E. Uniform</option>
                        <option value="id_laces" <?= $product['category'] == 'id_laces' ? 'selected' : '' ?>>ID Laces</option>
                        <option value="elementary_uniform" <?= $product['category'] == 'elementary_uniform' ? 'selected' : '' ?>>Elementary Uniform</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="productName">Product Name</label>
                    <input type="text" id="productName" name="productName" value="<?= htmlspecialchars($product['product_name']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4" required><?= htmlspecialchars($product['description']) ?></textarea>
                </div>

                <div class="form-group">
                    <label>Product Images</label>
                    <div class="image-upload">
                        <input type="file" id="product-images" name="productImages[]" multiple accept="image/*">
                        <label for="product-images" class="upload-label">
                            <i class="bx bx-cloud-upload"></i>
                            <span>Click to upload or drag and drop</span>
                            <div class="preview-container" id="image-preview">
                                <?php foreach ($images as $image): ?>
                                <div class="preview-item">
                                    <img src="../<?= htmlspecialchars($image) ?>" alt="Product Image">
                                    <input type="hidden" name="existing_images[]" value="<?= htmlspecialchars($image) ?>">
                                    <div class="delete-image" data-image="<?= htmlspecialchars($image) ?>">
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="size">Size</label>
                        <div class="size-options">
                            <?php 
                            $allSizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
                            foreach ($allSizes as $size): 
                            ?>
                            <label class="size-checkbox">
                                <input type="checkbox" name="sizes[]" value="<?= $size ?>" 
                                    <?= in_array($size, $sizes) ? 'checked' : '' ?>>
                                <?= $size ?>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="price">Price (₱)</label>
                        <input type="number" id="price" name="price" min="0" step="0.01" 
                            value="<?= $product['price'] ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="material">Material</label>
                        <input type="text" id="material" name="material" 
                            value="<?= htmlspecialchars($product['material']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="quantity">Available Quantity</label>
                        <input type="number" id="quantity" name="quantity" min="0" 
                            value="<?= $product['quantity'] ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="tags">Tags</label>
                    <input type="text" id="tags" name="tags" placeholder="e.g., summer, new, limited"
                        value="<?= htmlspecialchars($product['tags']) ?>">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        <i class="bx bx-save"></i> Update
                    </button>
                    <a href="view-products.php" class="btn-reset">
                        <i class="bx bx-arrow-back"></i> Back
                    </a>
                </div>
            </form>
        </div>
    </div>
</main>
    </section>
        
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../script.js"></script>
    <script src="../scripts/edit-product.js"></script>                              
    
</body>
</html>