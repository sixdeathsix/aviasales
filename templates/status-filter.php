<div class="df w-90 jcsb">

    <form method="post">
        <input name="start" type="date">
        <span> - </span>
        <input name="end" type="date">
        <button>обновить</button>
    </form>

    <form method="post">
        <select name="sort" onchange="this.form.submit()">
            <option value="" hidden>
                <?php if($_SESSION['status'] == 'Landed'): ?>
                    Закрыт
                <?php elseif($_SESSION['status'] == 'Cancelled'): ?>
                    Отменен
                <?php elseif($_SESSION['status'] == ''): ?>
                    Все
                <?php endif; ?>
            </option>
            <option value="">Все</option>
            <option value="Landed">Закрыт</option>
            <option value="Cancelled">Отменен</option>
        </select>
    </form>

</div>