<?php

namespace application\controllers;

use application\core\Controller;
use application\libs\Db;
use application\core\View;

class MainController extends Controller
{

    public function indexAction()
    {
        if (isset($_GET["PAGE"])) {
            $page = (int)$_GET["PAGE"];
        } else {
            $page = 1;
        }
        $orderByFields = [];

        $data['count'] = $this->model->getTasksCount();
        if (isset($_GET["SORT"])) {
            $orderByFields = [$_GET["SORT"]];
        }

        $notesCount = 3; //количество записей на страницу

        $data['tasks'] = $this->model->pagination(array('*'), $page, $notesCount, $orderByFields); //получаем сортированый список задач
        //$data['tasks'] = $this->model->getTasks();
        $data['assignees'] = $this->model->getAssignees();
        $this->view->render('Главная', $data);
    }

    public function loginAction()
    {
        if (!empty($_POST)) {
            if (!$this->model->loginValidate($_POST)) {
                $this->view->message('Неверные данные', $this->model->error);
            }
            $_SESSION['admin'] =  true;
        }
    }

    public function logoutAction()
    {
        unset($_SESSION['admin']);
    }

    public function addTaskAction()
    {
        //добавление записи
        if (!empty($_POST)) {
            $id = $this->model->taskAdd($_POST);

            if (!$id) {
                $this->view->message('error', 'что-то пошло не так');
            }
            $this->view->message('success', 'Задача добавлена');
        }
        //--
        $this->view->render('Добавление задачи'); //рендер
    }

    public function editTaskAction()
    {
        //изменение записи
        if (!empty($_POST)) {
            $id = $this->model->taskEdit($this->route['id'], $_POST);

            if (!$this->route['id']) {
                $this->view->message('error', 'что-то пошло не так');
            }
            $this->view->message('success', 'Задача изменена');
        }
        //--

        //рендер
        $params = [
            'id' => $this->route['id'],
        ];
        $data = $this->model->getTasks($params);

        if (empty($data)) {
            $this->view->errorCode(404);
        }

        $this->view->render('Редактирование задачи', $data[0]);
        //--
    }

    public function taskMarkedReadyAction()
    {
        $_POST['ready'] = ($_POST['ready'] == 1) ? 0 : 1;

        $id = $this->model->taskReady($_POST['ready_id'], ['ready' => $_POST['ready']]);
    }
}
