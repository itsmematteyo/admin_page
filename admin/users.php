<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <!-- STYLES -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../styles/users.css">
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
            <h1>Users</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li>
                    <i class="bx bx-chevron-right"></i>
                </li>
                <li>
                    <a class="active" href="#">Users</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>User Management</h3>
                <div class="search-filter">
                    <div class="form-input">
                        <input type="search" placeholder="Search users...">
                        <button type="submit" class="search-btn"><i class="bx bx-search"></i></button>
                    </div>
                    <div class="dropdown">
                        <button class="dropbtn"><i class="bx bx-filter"></i> Filter</button>
                        <div class="dropdown-content">
                            <a href="#">All Users</a>
                            <a href="#">Active</a>
                            <a href="#">Archived</a>
                            <a href="#">By Department</a>
                        </div>
                    </div>
                    <button class="btn-add">
                        <i class="bx bx-plus"></i> Add User
                    </button>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th class="text-center">Student ID</th>
                        <th class="text-left">First Name</th>
                        <th class="text-left">Last Name</th>
                        <th class="text-left">Email</th>
                        <th class="text-left">Department</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">2023-001</td>
                        <td class="text-left">John</td>
                        <td class="text-left">Doe</td>
                        <td class="text-left">john.doe@university.edu</td>
                        <td class="text-left">Computer Science</td>
                        <td class="text-center">
                            <a href="#" class="btn-edit"><i class="bx bx-edit"></i></a>
                            <a href="#" class="btn-archive"><i class="bx bx-archive"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</main>
    </section>
        
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../script.js"></script>
</body>
</html>