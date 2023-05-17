<?php

namespace application\models;

use application\core\Model;

class Main extends Model
{

    public function loginValidate($post)
    {
        $config = require 'application/config/admin.php';
        if ($config['login'] != $post['login'] || !password_verify($post['password'], $config['password'])) {
            $this->error = 'error';
            return false;
        }
        return true;
    }

    public function pagination($arSelect = [], $page = 1, $notesCount = null, $orderByFields = [])
    {
        $table = 'issues';

        $data = $this->db->get($table, $arSelect, array(), null, $page, $notesCount, $orderByFields);

        return $data;
    }

    public function getAssignees($conditionParams = [], $arSelect = []) //можно вывести несколько записей, если не передавать $conditionParams
    {
        $table = 'assignees';

        $data = $this->db->get($table, $arSelect, $conditionParams, '=');

        return $data;
    }

    public function getTasks($conditionParams = [], $arSelect = []) //можно вывести несколько записей, если не передавать $conditionParams
    {
        $table = 'issues';

        $data = $this->db->get($table, $arSelect, $conditionParams, '=');

        return $data;
    }

    public function taskAdd($post)
    {
        $table = 'issues';
        $params = [];
        $params = $this->updateParamsArr($post, $params);
        $this->db->insert($table, $params);

        $data = $this->db->lastInsertId();

        return $data;
    }

    public function taskReady($id, $post) //изменение маркера готовности задачи
    {
        $table = 'issues';
        $conditionParams = [
            'id' => $id,
        ];
        $params = $post;

        $data = $this->db->update($table, $params, $conditionParams);

        return $data;
    }

    public function taskEdit($id, $post)
    {
        $table = 'issues';
        $conditionParams = [
            'id' => $id,
        ];
        $params = $post;

        $data = $this->db->update($table, $params, $conditionParams);

        return $data;
    }

    public function getTasksCount()
    {
        $data = $this->db->count();

        return $data;
    }
}
