<nav class="navbar navbar-expand-sm bg-light justify-content-center">
    <a class="brand" href="admin.php">Trang Giám Đốc</a>
    <ul class="navbar-nav">
        <div class="row">
            <li class="nav-item col-3"><a class="nav-link" href="admin.php?order=manageStaff">Manage Staff</a></li>
            <li class="nav-item col-3"><a class="nav-link" href="admin.php?order=manageReport">Manage manager report</a></li>
            <li class="nav-item col-3">
                <div><img style="max-width: 50px;" src="<?="../".$data['image']?>" alt=""></div>
                <div class="m-1 text-primary"><?=$data['firstName']."".$data['lastName']?></div>
            </li>
            <li class="nav-item col-3"><a href="../logout.php"><i class="fa-solid fa-screwdriver-wrench"></i> Logout</a></li>
        </div>
    </ul>
</nav>