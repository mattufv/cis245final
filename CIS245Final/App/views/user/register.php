<div class="card">
    <h2>Register</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <p>Role:</p>
        <select name="role" id="role">
            <option value="user" selected>User</option>
            <option value="admin">Admin</option>
        </select>
        <button type="submit">Register</button>
    </form>

    <?php if (isset($error)) echo "<p>$error</p>"; ?>
</div>