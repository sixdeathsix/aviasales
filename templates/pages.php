<div class="pages">
    <?php if($pages > 1): ?>

        <?php for($i = 1; $i <= $pages; $i++): ?>
            <a
                class="page-number <?= $_GET['page'] == $i ? 'selected' : '' ?>"
                href="?page=<?= $i ?>"
            >
                <?= $i ?>
            </a>
        <?php endfor; ?>

    <?php endif; ?>
</div>