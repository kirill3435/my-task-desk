<?php session_start(); ?>
<?php
/*echo '<pre>';
var_dump($data_tasks);
echo '</pre>'; */ ?>
<h1 class="title">Список задач</h1>

<div class="sort-btns">
    <div class="sort" data-sort-type="deadline">дедлайн</div>

    <div class="sort" data-sort-type="ready">статус</div>

    <div class="sort" data-sort-type="assignee">Исполнитель</div>
</div>
<br>

<div class="add-btn-container">
    <a href="/add">
        добавить задачу
    </a>
</div>

<?php foreach ($data_tasks as $task) { ?>
    <div class="task">

        <div class="task-header">
            <?php
            switch ((int)$task['assignee']) {
                case 0:
                    $assigneeColor = 'lightblue';
                    break;
                case 1:
                    $assigneeColor = 'pink';
                    break;
                default:
                    $assigneeColor = 'linear-gradient(to bottom left, pink 50%, lightblue 50%)';
                    break;
            }
            ?>
            <div class="task-header-cell">
                <span class="assignee" style="background: <?php echo $assigneeColor; ?>;">
                    <?php
                    echo $data_assignees[($task['assignee'])]['name']; //костыль, переделать
                    ?>
                </span>
            </div>

            <div class="task-header-cell">
                <span><b>Дедлайн: </b></span>
                <span><?php echo $task['deadline']; ?></span>
            </div>

            <div class="task-header-cell">
                <form id="readyMark" action="/taskMarkedReady" method="post">
                    <input name="ready_id" type="hidden" value=<?php echo $task['id']; ?>>

                    <input name="ready" type="hidden" value="<?php echo $task['ready']; ?>">

                    <?php
                    switch ((int)$task['ready']) {
                        case 1:
                            $markReadyColor = 'lightgreen';
                            break;
                        default:
                            $markReadyColor = 'indianred';
                            break;
                    }
                    ?>

                    <button class="mark-ready" style="background: <?php echo $markReadyColor; ?>;" type="submit"><?php echo ($task['ready'] == 1) ? 'выполнена' : 'не выполнена'; ?></button>
                </form>
            </div>
        </div>
        <div>
            <?php echo $task['description']; ?>
        </div>

        <a href="edit/<?php echo $task['id']; ?>">редактировать</a>
    </div>
    <br>
<?php } ?>

<div>
    <?php if ($data_count > 3) { ?>
        <?php if ($data_count % 3 != 0) {
            $pagesCount = intdiv($data_count, 3) + 1;
        } else {
            $pagesCount = $data_count / 3;
        }
        if (isset($_GET["PAGE"])) {
            $activePage = (int)htmlspecialchars($_GET["PAGE"]);
        } else {
            $activePage = 1;
        } ?>
        <div class="pagination">
            <?php for ($i = 1; $i <= $pagesCount; $i++) { ?>
                &nbsp;<div class="pagination-btn<? if ($activePage == $i) {
                                                    echo ' active';
                                                } ?>" data-pg-id="<?php echo $i ?>"><?php echo $i ?></div>&nbsp;
            <?php } ?>
        </div>
    <?php } ?>
</div>
<?php session_destroy(); ?>