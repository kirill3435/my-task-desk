<h1 class="title">Редактирование записи</h1>

<div class="form-container">
    <form class="edit-form" action="/edit/<?php echo $data_id; ?>" method="post">
        <div class="input-form-container">
            <span>описание</span>

            <textarea name="description" maxlength=500 type="text" require><?php echo $data_description; ?></textarea>
        </div>

        <div class="input-form-container">
            <span>исполнитель</span>

            <input name="assignee" type="text" require value="<?php echo $data_assignee; ?>">
        </div>

        <div class="input-form-container">
            <span>Дедлайн</span>

            <input name="deadline" type="date" require value="<?php echo $data_deadline; ?>">
        </div>

        <input name="ready" type="hidden" value="<?php echo $data_ready; ?>">

        <button type="submit">Изменить</button>
    </form>
</div>