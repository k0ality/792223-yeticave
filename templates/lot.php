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
    <section class="lot-item container">
        <?php if (isset($one_lot)) : ?>
            <h2><?= user_input_filter($one_lot['product']); ?></h2>
            <div class="lot-item__content">
                <div class="lot-item__left">
                    <div class="lot-item__image">
                        <img src="<?= $one_lot['image']; ?>" width="730" height="548" alt="<?= user_input_filter($one_lot['product']); ?>">
                    </div>
                    <p class="lot-item__category">Категория: <span><?= $one_lot['cat_name']; ?></span></p>
                    <p class="lot-item__description"><?= $one_lot['description']; ?></p>
                </div>

                <div class="lot-item__right">
                    <div class="lot-item__state">
                        <div class="lot-item__timer timer">
                            <?= time_before_tomorrow(); ?>
                        </div>
                        <div class="lot-item__cost-state">
                            <div class="lot-item__rate">
                                <span class="lot-item__amount">Текущая цена</span>
                                <span class="lot-item__cost">
                                 <?= format_price(user_input_filter($current_price)); ?>
                                </span>
                            </div>
                            <div class="lot-item__min-cost">
                                Мин. ставка <span><?= format_price($min_bid); ?></span>
                            </div>
                        </div>
                        <?php if (isset($is_auth) && $is_auth['id'] !== $one_lot['seller_id']) : ?>
                            <form class="lot-item__form" action="lot.php?id=<?= user_input_filter($one_lot['id']); ?>" method="post">
                                <?php $css_class_form = !empty($errors) ? 'form__item--invalid' : ''; ?>
                                <p class="lot-item__form-item form__item <?= $css_class_form; ?>">
                                    <label for="cost">Ваша ставка</label>
                                    <input id="cost" type="text" name="new_bid" placeholder="<?= format_price($min_bid); ?>">
                                    <?php if (isset($errors)) : ?>
                                            <span class="form__error"><?= $errors['new_bid']; ?></span>
                                    <?php endif; ?>
                                </p>
                                <button type="submit" class="button">Сделать ставку</button>
                            </form>
                        <?php endif; ?>
                    </div>
                    <div class="history">
                        <h3>История ставок (<span><?= count($bids) ;?></span>)</h3>
                        <table class="history__list">
                            <?php if ($bids) :?>
                                <?php foreach ($bids as $bid) :?>
                                    <tr class="history__item">
                                        <td class="history__name"><?=user_input_filter($bid['username']); ?></td>
                                        <td class="history__price"><?=format_price($bid['amount']); ?></td>
                                        <td class="history__time"><?=time_since_bid($bid['create_time']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </section>
</main>
