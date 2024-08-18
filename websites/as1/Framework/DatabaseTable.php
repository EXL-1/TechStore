<?php 

namespace Framework;
class DatabaseTable {
    private $table;
    private $pdo;
    private $primaryKey;

    public function __construct($pdo, $table, $primaryKey) {
        $this->pdo = $pdo;
        $this->table = $table;
        $this->primaryKey = $primaryKey;
    }

public function find($field, $value)
{
    $stmt = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE ' . $field . ' = :value');

    $values = [
        'value' => $value
    ];

    $stmt->execute($values);

    return $stmt->fetch();
}

public function findMutiple($field, $value)
{
    $stmt = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE ' . $field . ' = :value');

    $values = [
        'value' => $value
    ];

    $stmt->execute($values);

    return $stmt->fetchall();
}

public function findAll()
{
    $stmt = $this->pdo->prepare('SELECT * FROM ' . $this->table);

    $stmt->execute();

    return $stmt->fetchall();
}

public function findMostRecent($value, $number)
{
    $stmt = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' ORDER BY ' . $value . ' DESC LIMIT ' . $number);

    $stmt->execute();

    return $stmt->fetchall();
}


public function delete($field, $value)
{
    $stmt = $this->pdo->prepare('DELETE FROM ' . $this->table . ' WHERE ' . $field . ' = :value');

    $values = [
        'value' => $value
    ];

    $stmt->execute($values);
}

public function deleteAll()
{
    $stmt = $this->pdo->prepare('DELETE FROM ' . $this->table . '');

    $stmt->execute();
}

public function countAll() {
    $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM ' . $this->table);
    $stmt->execute();

    return $stmt->fetchColumn();
}

public function count($field, $value) {
    $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM ' . $this->table. ' WHERE ' . $field . ' = :value');

    $values = [
        'value' => $value
    ];

    $stmt->execute($values);

    return $stmt->fetchColumn();
}

public function insert($record)
{

    $keys = array_keys($record);

    $values = implode(',', $keys);
    $valuesWithColon = implode(', :', $keys);

    $query = 'INSERT INTO ' . $this->table . ' (' . $values . ') VALUES (:' . $valuesWithColon . ')';

    $stmt = $this->pdo->prepare($query);

    $stmt->execute($record);
}

public function update($record) {

    $query = 'UPDATE ' . $this->table . ' SET ';

    $parameters = [];
    foreach($record as $key => $value) {
        $parameters[] = $key . ' = :' .$key;
    }

    $query .= implode(', ', $parameters);
    $query .= ' WHERE ' . $this->primaryKey . ' = :primaryKey';

    $record['primaryKey'] = $record[$this->primaryKey];

    $stmt = $this->pdo->prepare($query);
    $stmt->execute($record);
}
public function save($record) {
    if (empty($record[$this->primaryKey])) {
        unset($record[$this->primaryKey]);
    }
    try {
        $this->insert($record);
    }
    catch (\Exception $e) {
        $this->update($record);
    }
}
}
