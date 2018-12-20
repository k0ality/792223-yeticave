<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $category): ?>
                <li class="nav__item">
                    <a href="all-lots.html"><?= user_input_filter($category['name']); ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <?php $css_class_form = isset($errors) ? "form--invalid" : ""; ?>
    <form class="form container <?= $css_class_form; ?>" action="../sign-up.php" method="post" enctype="multipart/form-data">
        <h2>Регистрация нового аккаунта</h2>
        <?php $css_class_form = isset($errors['email']) ? "form__item--invalid" : "";
        $value = isset($sign_up['email']) ? user_input_filter($sign_up['email']) : ""; ?>
        <div class="form__item <?= $css_class_form; ?>">
            <label for="email">E-mail*</label>
            <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= $value; ?>">
            <span class="form__error"><?= $errors['email']; ?></span>
        </div>
        <?php $css_class_form = isset($errors['password']) ? "form__item--invalid" : ""; ?>
        <div class="form__item <?= $css_class_form; ?>">
            <label for="password">Пароль*</label>
            <input id="password" type="text" name="password" placeholder="Введите пароль">
            <span class="form__error"><?= $errors['password']; ?></span>
        </div>
        <?php $css_class_form = isset($errors['username']) ? "form__item--invalid" : "";
        $value = isset($sign_up['username']) ? user_input_filter($sign_up['username']) : ""; ?>
        <div class="form__item <?= $css_class_form; ?>">
            <label for="username">Имя*</label>
            <input id="username" type="text" name="username" placeholder="Введите имя" value="<?= $value; ?>">
            <span class="form__error"><?= $errors['username']; ?></span>
        </div>
        <?php $css_class_form = isset($errors['contact']) ? "form__item--invalid" : "";
        $value = isset($sign_up['contact']) ? user_input_filter($sign_up['contact']) : ""; ?>
        <div class="form__item <?= $css_class_form; ?>">
            <label for="contact">Контактные данные*</label>
            <textarea id="contact" name="contact" placeholder="Напишите как с вами связаться"><?= $value; ?></textarea>
            <span class="form__error"><?= $errors['contact']; ?></span>
        </div>
        <?php $css_class_form = isset($errors['image']) ? "form__item--invalid" : ""; ?>
        <div class="form__item form__item--file form__item--last <?= $css_class_form; ?>">
            <label>Аватар</label>
            <div class="preview">
                <button class="preview__remove" type="button">x</button>
                <div class="preview__img">
                    <img src="img/avatar.jpg" width="113" height="113" alt="Ваш аватар">
                </div>
            </div>
            <span class="form__error"><?= $errors['image']; ?></span>
            <div class="form__input-file">
                <input class="visually-hidden" type="file" id="photo2" name="jpg_img" value="">
                <label for="photo2">
                    <span>+ Добавить</span>
                </label>
            </div>
        </div>
        <span class="form__error form__error--bottom"><?= $errors['hint']; ?></span>
        <button type="submit" class="button">Зарегистрироваться</button>
        <a class="text-link" href="#">Уже есть аккаунт</a>
    </form>
</main>
