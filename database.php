<?php
require_once 'businesslogic.php';
function insert($table, $columns, $values) {
    global $pdo;
    $columnsStr = implode(', ', $columns);
    $placeholders = implode(', ', array_fill(0, count($values), '?'));
    $sql = "INSERT INTO $table ($columnsStr) VALUES ($placeholders)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($values);
    return $pdo->lastInsertId();
}

function update($table, $columns, $values, $whereCondition, $whereValues) {
    global $pdo;
    $setClause = implode(' = ?, ', $columns) . ' = ?';
    $sql = "UPDATE $table SET $setClause WHERE $whereCondition";
    echo "<pre>";
    echo "SQL: $sql\n";
    echo "Values: ";
    print_r(array_merge($values, $whereValues));
    echo "</pre>";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(array_merge($values, $whereValues));
    return $stmt->rowCount();
}
function delete($table, $whereCondition, $whereValues) {
    global $pdo;
    $sql = "DELETE FROM $table WHERE $whereCondition";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($whereValues);
    return $stmt->rowCount();
}

function select($table, $columns = ['*'], $whereCondition = '', $whereValues = []) {
    global $pdo;
    $columnsStr = implode(', ', $columns);
    $sql = "SELECT $columnsStr FROM $table";
    if (!empty($whereCondition)) {
        $sql .= " WHERE $whereCondition";
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute($whereValues);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>