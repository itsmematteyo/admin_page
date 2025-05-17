<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <!-- STYLES -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../styles.css">
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
                <span class="num">9+</span>
            </a>
            <a href="#" class="profile">
                <img src="">
            </a>
        </nav>

        <!-- MAIN -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Dashboard</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Dashboard</a>
                        </li>
                        <li>
                            <i class="bx bx-chevron-right"></i>
                        </li>
                        <li>
                            <a class="active" href="#">Home</a>
                        </li>
                    </ul>
                </div>
            </div>

            <ul class="box-info">
                <li>
                    <i class="bx bxs-shopping-bag"></i>
                    <span class="text">
                        <h3>Products</h3>
                        <p>100</p>
                    </span>
                </li>
                <li>
                    <i class="bx bxs-user"></i>
                    <span class="text">
                        <h3>Users</h3>
                        <p>50</p>
                    </span>
                </li>
                <li>
                    <i class="bx bxs-dollar-circle"></i>
                    <span class="text">
                        <h3>Sales</h3>
                        <p>$5000</p>
                    </span>
                </li>
            </ul>

            <div class="table-data">
                <div class="head">
                    <h3>Recent Orders</h3>
                    <i class="bx bx-search"></i>
                </div>
                <table>
                    <thead>
                        <tr>
                            <td>Order ID</td>
                            <td>Product</td>
                            <td>Status</td>
                            <td>Date</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#12345</td>
                            <td>Product 1</td>
                            <td><span class="status delivered">Delivered</span></td>
                            <td>2023-10-01</td>
                        </tr>
                        <tr>
                            <td>#12346</td>
                            <td>Product 2</td>
                            <td><span class="status delivered">Delivered</span></td>
                            <td>2023-10-02</td>
                        </tr>
                        <tr>
                            <td>#12347</td>
                            <td>Product 3</td>
                            <td><span class="status delivered">Delivered</span></td>
                            <td>2023-10-03</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="statistics-graph">
                <div class="head">
                    <h3>Sales Statistics</h3>
                    <i class="bx bx-search"></i>
                </div>
                <canvas id="myChart"></canvas>
            </div>
        </main>
    </section>
        
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../script.js"></script>
</body>
</html>