<header>
    <h1>CIS 245 Final</h1>
</header>
    <nav>
        <?php /*
        <a href="./">Home</a>
        <?php if (isset($_SESSION["id"])): ?>
        <a href="?controller=note&method=getlist">View Notes</a>
        <a href="?controller=note&method=add">Add Note</a>
        <a href='?controller=user&method=logout'>Logout</a>
        <?php endif; ?>
        <?php if (!isset($_SESSION["id"])): ?>
        <a href="?controller=user&method=login">Login</a>
        <a href="?controller=user&method=register">Register</a>
        <?php endif; ?>
        <?php if (isset($_SESSION{'role'}) && $_SESSION["role"] === "admin"): ?>
        <a href="?controller=admin&method=dashboard">Admin Dashboard</a>
        <?php endif; ?>
        <?php if (isset($_SESSION["id"])): ?>
        Logged in as <strong><?php echo $_SESSION["username"]; ?></strong>
        <?php endif; ?>
        */ ?>
        <a href="./">Home</a>
        <a href="?controller=home&method=resume">Resume</a>
        <a href="?controller=home&method=projects">Past Projects</a>
        <a href="?controller=product&method=get_list">My Products</a>
        
        <a href="?controller=news&method=get_list">News</a>
        <?php if (isset($_SESSION{'role'}) && $_SESSION["role"] === "admin"): ?>
        <a href="?controller=admin&method=dashboard">Admin Dashboard</a>
        <?php endif; ?>
        <?php if (!isset($_SESSION["id"])): ?>
        <a href="?controller=user&method=register">Register an Account</a>
        <a href="?controller=user&method=login">Login</a>
        <?php endif; ?>
        <?php if (isset($_SESSION["id"])): ?>
        <a href="?controller=user&method=logout">Logout</a>
        <?php endif; ?>
        

    </nav>
