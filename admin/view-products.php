<?php
// Database connection
require_once '../Database/dbconnection.php';

// Function to determine stock status
function getStockStatus($quantity) {
    if ($quantity == 0) {
        return 'out-stock';
    } elseif ($quantity <= 10) {
        return 'low-stock';
    } else {
        return 'in-stock';
    }
}

// Fetch products from database
$products = [];
try {
    $stmt = $pdo->query("
        SELECT p.*, 
               GROUP_CONCAT(DISTINCT ps.size) AS sizes,
               GROUP_CONCAT(DISTINCT pi.image_path) AS images
        FROM products p
        LEFT JOIN product_sizes ps ON p.product_id = ps.product_id
        LEFT JOIN product_images pi ON p.product_id = pi.product_id
        GROUP BY p.product_id
    ");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../styles/view-product.css">
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
                <a href="Messages">
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
            <h1>View Products</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li>
                    <i class="bx bx-chevron-right"></i>
                </li>
                <li>
                    <a class="active" href="#">View Products</a>
                </li>
            </ul>
        </div>
    </div>

    <div id="view-products-container">
        <div class="table-controls">
            <div class="table-header">
                <div class="table-title">Products</div>
                <div class="search-filter-container">
                    <div class="search-box">
                        <i class='bx bx-search'></i>
                        <input type="text" id="product-search" placeholder="Search products...">
                    </div>
                    <div class="filter-dropdown">
                        <select id="status-filter">
                            <option value="">All Status</option>
                            <option value="in-stock">In Stock</option>
                            <option value="low-stock">Low Stock</option>
                            <option value="out-stock">Out of Stock</option>
                        </select>
                        <i class='bx bx-chevron-down'></i>
                    </div>
                    <div class="filter-dropdown">
                        <select id="category-filter">
                            <option value="">All Categories</option>
                            <option value="Dept. Shirt">Dept. Shirt</option>
                            <option value="College Uniform">College Uniform</option>
                            <option value="P.E. Uniform">P.E. Uniform</option>
                            <option value="ID Laces">ID Laces</option>
                            <option value="Elementary Uniform">Elementary Uniform</option>
                        </select>
                        <i class='bx bx-chevron-down'></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="table-container">
            <table id="products-table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): 
                        $status = getStockStatus($product['quantity']);
                        $categoryMap = [
                            'dept_shirt' => 'Dept. Shirt',
                            'college_uniform' => 'College Uniform',
                            'pe_uniform' => 'P.E. Uniform',
                            'id_laces' => 'ID Laces',
                            'elementary_uniform' => 'Elementary Uniform'
                        ];
                        $category = $categoryMap[$product['category']] ?? $product['category'];
                    ?>
                    <tr data-product-id="<?= $product['product_id'] ?>">
                        <td><?= htmlspecialchars($product['product_name']) ?></td>
                        <td><?= htmlspecialchars($category) ?></td>
                        <td>₱<?= number_format($product['price'], 2) ?></td>
                        <td><?= $product['quantity'] ?></td>
                        <td><span class="status <?= $status ?>">
                            <?= ucfirst(str_replace('-', ' ', $status)) ?>
                        </span></td>
                        <td>
                            <button class="action-btn edit" data-product-id="<?= $product['product_id'] ?>">
                                <i class='bx bx-edit'></i>
                            </button>
                            <button class="action-btn archive" data-product-id="<?= $product['product_id'] ?>">
                                <i class='bx bx-archive'></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
    </section>
        
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../script.js"></script>
    <script src="../scripts/view-product.js"></script>
</body>
</html>