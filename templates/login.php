<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $category) : ?>
                <li class="nav__item">
                    <a href="pages/all-lots.html"><?= $category['name']; ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <?php $css_class_form = isset($errors) ? "form--invalid" : ""; ?>
    <form class="form container <?= $css_class_form;?>" action="/login.php" method="post" enctype="multipart/form-data">
        <h2>Вход</h2>
        <?php $css_class_form = isset($errors['email']) ? "form__item--invalid" : "";
        $value = isset($login['email']) ? user_input_filter($login['email']) : ""; ?>
        <div class="form__item <?= $css_class_form;?>">
            <label for="email">E-mail*</label>
            <input id="email" type="email" name="email" placeholder="Введите e-mail" value="<?= $value; ?>">
            <span class="form__error"><?= $errors['email'] ?? ""; ?></span>
        </div>
        <?php $css_class_form = isset($errors['password']) ? "form__item--invalid" : "";
        $value = isset($login['password']) ? user_input_filter($login['password']) : ""; ?>
        <div class="form__item form__item--last <?= $css_class_form;?>">
            <label for="password">Пароль*</label>
            <input id="password" type="password" name="password" placeholder="Введите пароль">
            <span class="form__error"><?= $errors['password'] ?? ""; ?></span>
        </div>
        <button type="submit" class="button">Войти</button>
    </form>
</main>
