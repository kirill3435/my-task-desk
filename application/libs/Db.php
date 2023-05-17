<?php

namespace application\libs;

use PDO;

class Db
{

    public function __construct()
    {
        $config = require 'application/config/db.php';
        $host = $config['host'];
        $db   = $config['dbname'];
        $user = $config['user'];
        $pass = $config['password'];
        $charset = 'utf8';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $this->db = new PDO($dsn, $user, $pass, $opt);
    }

    public function query($sql, $params = [])
    {
        $stmt = $this->db->prepare($sql);

        $stmt->execute($params);
        return $stmt;
    }

    public function row($sql, $params = []) //лучше не использовать, вместо этого get()/insert()/update()
    {
        $result = $this->query($sql, $params);
        return $result->fetchAll();
    }

    public function lastInsertId()
    {
        return $this->db->lastInsertId();
    }

    public function get($table, $arrSelect = [], $params = [], $conditionOperator = null, $limitPage = null, $notesCount = null, $orderByFields = [])
    {
        $conditionValues = [];
        if (!empty($arrSelect)) {
            $strSelect = '';
            foreach ($arrSelect as $fieldName) {
                if ($fieldName !== '*') {
                    $field = "`" . str_replace("`", "``", $fieldName) . "`";
                } else {
                    $field = str_replace("`", "``", $fieldName);
                }
                $strSelect .= $field . ', ';
            }
            $strSelect = substr($strSelect, 0, -2);
        } else {
            $strSelect = '*';
        }

        $strWhere = '';
        if (!empty($params) && !empty($conditionOperator)) {
            $strWhere = ' WHERE ' . $this->pdoWhere($params, $conditionValues, $conditionOperator)['where'];
        }

        $strOrderBy = '';
        if (!empty($orderByFields)) {
            $strOrderBy = $this->orderByShielding($orderByFields);
        }

        $strLimit = '';
        if (!empty($limitPage)) {

            $strLimit = $this->limitShielding($limitPage, $notesCount);
        }

        $sql = 'SELECT ' . $strSelect . ' FROM `' . $table . '`' . $strWhere . $strOrderBy . $strLimit;

        $result = $this->query($sql, $conditionValues);
        return $result->fetchAll();
    }

    public function insert($table, $params)
    {

        $sql = 'INSERT INTO `' . $table . '` SET ' . $this->pdoSet($params, $values);
        $params;
        $this->query($sql, $values);
    }

    public function update($table, $params, $conditionParams) //сейчас в conditionParams должен быть только id. TODO: добавить другие параметры для WHERE
    {
        $sql = 'UPDATE `' . $table . '` SET ' . $this->pdoSet($params, $values, $conditionParams) . ' WHERE ' . $this->pdoWhere($conditionParams, $conditionValues, '=')['where'];
        $this->query($sql, $values);
    }

    public function count()
    {
        return $this->query('SELECT COUNT(*) as count FROM `issues`')->fetchColumn();
    }

    //---------------------------//
    //ниже только private функции//
    //---------------------------//

    //сборка строки с параметрами для PDO
    private function pdoSet($params, &$values, $conditionParams = [])
    {
        $set = '';
        $values = [];
        foreach ($params as $field => $value) {
            $set .= '`' . str_replace('`', '``', $field) . '`' . '=:' . $field . ', ';
            $values[$field] = $value;
        }
        if (!empty($conditionParams)) {
            foreach ($conditionParams as $field => $value) {
                $values[$field] = $value;
            }
        }

        return substr($set, 0, -2);
    }
    //--

    private function pdoWhere($params, &$conditionValues, $operator = '=') //если нужно несколько условий в where - в запросе вызывай эту функцию на каждое условие разделяя логическим оператором(and, or и тд)
    {
        $conditionValues = [];
        $arrReturn = [
            'in' => '',
            'like' => '',
            'between' => '',
            'where' => '',
        ];
        //TODO: дописать in, like, between
        switch ($operator) {
            case 'IN':
                $arrReturn['in'] = '';
                break;
            case 'LIKE':
                $arrReturn['like'] = '';
                break;
            case 'BETWEEN':
                $arrReturn['between'] = '';
                break;
            default:
                $where = '';
                foreach ($params as $field => $value) {
                    $conditionValues[$field] = $value;
                    $where .=  '`' . str_replace('`', '``', $field) . '` ' . $operator . ' :' . $field;
                    $arrReturn['where'] = $where;
                }
                break;
        }

        return $arrReturn;
    }

    private function orderByShielding($fields)
    {
        $strFields = ' ORDER BY ';
        foreach ($fields as $field) {
            $strFields .= "`" . str_replace("`", "``", $field) . "`, ";
        }
        return substr($strFields, 0, -2);
    }

    private function limitShielding($page, $notesCount = null)
    {
        if ($notesCount == null) {
            $notesCount = 3;
        }
        $notesCount = str_replace('`', '``', $notesCount); //изначально пагинация по 3 записи на страницу
        $limit = ' LIMIT ';
        $start = str_replace('`', '``', $page) * $notesCount - $notesCount;
        $limit .= $start . ', ' . $notesCount;

        return $limit;
    }
}
