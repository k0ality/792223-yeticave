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
        <form class="form form--add-lot container <?= $css_class_form; ?>" action="../add.php" method="post" enctype="multipart/form-data">
            <h2>Добавление лота</h2>
            <div class="form__container-two">
                <?php $css_class_form = isset($errors['product']) ? "form__item--invalid" : "";
                $value = isset($new_lot['product']) ? user_input_filter($new_lot['product']) : ""; ?>
                <div class="form__item <?= $css_class_form ;?>">
                    <label for="lot-name">Наименование</label>
                    <input id="lot-name" type="text" name="product" placeholder="Введите наименование лота" value="<?=$value; ?>">
                    <span class="form__error"><?= $errors['product']; ?></span>
                </div>
                <?php $css_class_form = isset($errors['category']) ? "form__item--invalid" : ""; ?>
                <div class="form__item">
                    <label for="category">Категория</label>
                    <select id="category" name="category">
                        <?php foreach ($categories as $category): ?>
                            <option><?=user_input_filter($category['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <span class="form__error"><?= $errors['category']; ?></span>
                </div>
            </div>
            <?php $css_class_form = isset($errors['description']) ? "form__item--invalid" : "";
            $value = isset($new_lot['description']) ? user_input_filter($new_lot['description']) : ""; ?>
            <div class="form__item form__item--wide <?= $css_class_form;?>">
                <label for="message">Описание</label>
                <textarea id="message" name="description" placeholder="Напишите описание лота"><?= $value; ?></textarea>
                <span class="form__error"><?= $errors['description']; ?></span>
            </div>
            <?php
            $css_class_form = "";
            if (isset($errors['image'])) {
                $css_class_form = "form__item--invalid";
            }
            ?>
            <!--if (!empty($file_url)) {
                $css_class_form = "form__item--uploaded";
            }
            -->
            <div class="form__item form__item--file <?= $css_class_form; ?>">
                <label>Изображение</label>
                <div class="preview">
                        <button class="preview__remove" type="button">x</button>
                        <div class="preview__img">
                            <img src="img/avatar.jpg" width="113" height="113" alt="Изображение лота">
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
            <div class="form__container-three">
                <?php $css_class_form = isset($errors['opening_price']) ? "form__item--invalid" : "";
                $value = isset($new_lot['opening_price']) ? user_input_filter($new_lot['opening_price']) : ""; ?>
                <div class="form__item form__item--small <?= $css_class_form; ?>">
                    <label for="lot-rate">Начальная цена</label>
                    <input id="lot-rate" type="text" name="opening_price" value="<?= $value; ?>" placeholder="0">
                    <span class="form__error"><?= $errors['opening_price']; ?></span>
                </div>
                <?php $css_class_form = isset($errors['price_increment']) ? "form__item--invalid" : "";
                $value = isset($new_lot['price_increment']) ? user_input_filter($new_lot['price_increment']) : ""; ?>
                <div class="form__item form__item--small <?= $css_class_form; ?>">
                    <label for="lot-step">Шаг ставки</label>
                    <input id="lot-step" type="text" name="price_increment" value="<?= $value; ?>" placeholder="0">
                    <span class="form__error"><?= $errors['price_increment']; ?></span>
                </div>
                <?php $css_class_form = isset($errors['closing_time']) ? "form__item--invalid" : "";
                $value = isset($new_lot['closing_time']) ? user_input_filter($new_lot['closing_time']) : ""; ?>
                <div class="form__item <?= $css_class_form; ?>">
                    <label for="lot-date">Дата окончания торгов</label>
                    <input class="form__input-date" id="lot-date" type="date"  name="closing_time" value="<?= $value; ?>">
                    <span class="form__error"><?= $errors['closing_time']; ?></span>
                </div>
            </div>
            <span class="form__error form__error--bottom"><?= $errors['hints']; ?></span>
            <button type="submit" class="button">Добавить лот</button>
        </form>
    </main>
