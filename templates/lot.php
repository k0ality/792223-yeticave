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
            <h2><?=user_input_filter($one_lot['product']);?></h2>
            <div class="lot-item__content">
                <div class="lot-item__left">
                    <div class="lot-item__image">
                        <img src="<?=$one_lot['image'];?>" width="730" height="548" alt="<?=user_input_filter($one_lot['product']);?>">
                    </div>
                    <p class="lot-item__category">Категория: <span><?=$one_lot['cat_name'];?></span></p>
                    <p class="lot-item__description"><?=$one_lot['description'];?></p>
                </div>
            </div>
        </section>
    </main>
