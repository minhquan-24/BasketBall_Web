<div class="row justify-content-center">
    <div class="col-md-6">
        <h1 class="text-center">Log in</h1>
        
        <!--  thông báo register thành công -->
        <?php if (isset($_GET['register_success'])): ?>
            <div class="alert alert-success">Succesful Register! Please Login.</div>
        <?php endif; ?>

        <!-- Lỗi nếu có -->
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="index.php?controller=auth&action=login" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Log in</button>
        </form>
        <p class="text-center mt-3">
            Don't have an account? <a href="index.php?controller=auth&action=register">Register here</a>
        </p>
    </div>
</div>