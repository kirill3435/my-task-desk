<h1 class="title">Добавление записи</h1>

<div class="form-container">
    <form class="add-form" action="/add" method="post">
        <div class="input-form-container">
            <span>описание</span>

            <textarea name="description" maxlength=500 type="text" require></textarea>
        </div>

        <div class="input-form-container">
            <span>исполнитель</span>

            <input name="assignee" type="text" require>
        </div>

        <div class="input-form-container">
            <span>Деллайн</span>

            <input name="deadline" type="date" require>
        </div>

        <input name="ready" value="" type="hidden">

        <button type="submit">Добавить</button>
    </form>
</div>