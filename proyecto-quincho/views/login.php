<h1>Login Administrador</h1>
<form method="POST">
    <label for="username">Usuario:</label>
    <input type="text" name="username" required>
    <label for="password">Contraseña:</label>
    <input type="password" name="password" required>
    <button type="submit">Login</button>
</form>
<?php if (isset($error)): ?>
    <p><?= $error ?></p>
<?php endif; ?>
