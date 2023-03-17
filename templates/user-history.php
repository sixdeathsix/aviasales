<?php

    if ($array_data) {
        $pagination = $mtd->pagination($array_data, $page_count, $_GET['page']);
        $array_data = $pagination['array'];
        $pages = $pagination['pages'];
    }

?>

<?php if($array_data): ?>

    <?php foreach($array_data as $item): ?>

        <div class="history-mobile">
            <div class="df jcsb">
                <p>Рейс № <?= $item['flight_id'] ?></p>
                <p>
                    <?= $mtd->convDate($item['scheduled_arrival']) ?>
                    <?= $mtd->convTime($item['scheduled_arrival']) ?>
                </p>
            </div>

            <div class="df jcsb">
                <div><?= $item['from_a'] ?>/<?= $item['from_n'] ?></div>
                <div>-</div>
                <div><?= $item['to_a'] ?>/<?= $item['to_n'] ?></div>
            </div>

            <div class="df jcsb">

                <div>Класс: <?= $item['class'] ?></div>

                <?php if($item['status'] == 'Landed'): ?>

                    <p class='landed'>Закрыт</p>

                <?php elseif($item['status'] == 'Cancelled'): ?>

                    <p class='cancelled'>Отменен</p>

                <?php elseif(!$item['ticket_id']): ?>

                    <p class='refund'>Возврат</p>

                <?php endif; ?>

            </div>

            <div class="df jcsb">
                <div>Кол-во билетов: <?= $item['count'] ?></div>
                <div>Сумма: <?= $item['total_amount'] ?> ₽</div>
            </div>

        </div>

    <?php endforeach; ?>

    <table class='history-table'>
        <tr class='history-tr'>
            <th>№</th>
            <th>Откуда</th>
            <th>Куда</th>
            <th>Прибытие</th>
            <th class="hide-tr">Класс</th>
            <th>Билетов</th>
            <th>Статус</th>
            <th>Сумма</th>
        </tr>

        <?php foreach($array_data as $item): ?>
            <tr class='history-tr'>
                <td><?= $item['flight_id'] ?></td>
                <td><?= $item['from_a'] ?>/<?= $item['from_n'] ?></td>
                <td><?= $item['to_a'] ?>/<?= $item['to_n'] ?></td>
                <td>
                    <?= $mtd->convDate($item['scheduled_arrival']) ?>
                    <?= $mtd->convTime($item['scheduled_arrival']) ?>
                </td>
                <td class="hide-tr"><?= $item['class'] ?></td>
                <td><?= $item['count'] ?></td>
                <td>

                    <?php if($item['status'] == 'Cancelled'): ?>

                        <p class='cancelled'>Отменен</p>

                    <?php elseif($item['ticket_id'] == null): ?>

                        <p class='refund'>Возврат</p>

                    <?php elseif($item['status'] == 'Landed'): ?>

                        <p class='landed'>Закрыт</p>

                    <?php endif; ?>

                </td>
                <td><?= $item['total_amount'] ?> </td>
            </tr>
        <?php endforeach; ?>

    </table>

<?php else: ?>

    <h2 class="tac">Нет данных</h2>

<?php endif; ?>


<?php require_once 'templates/pages.php'; ?>