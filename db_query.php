<?php

class MyDB extends SQLite3 {

  function __construct() {
    $this->open('DeploymentTracking.db');
  }
} //end my DB

function endDBConnection() {
  $db->close();
}

function query($sql) {
  $db = new MyDB();
  if (!$db) {
    echo $db->lastErrorMsg();
  } else {
    $ret = $db->query($sql);
    return $ret;
  }
}

function insert($sql) {
  $db = new MyDB();
  if (!$db) {
    echo $db->lastErrorMsg();
  } else {
    $ret = $db->query($sql);
    $lastId = $db->lastInsertRowid();
    return $lastId;
  }
}

function update($sql) {
  $db = new MyDB();
  if (!$db) {
    echo $db->lastErrorMsg();
  } else {
    $ret = $db->query($sql);
    $lastId = $db->lastInsertRowid();
    return $lastId;
  }
}

function delete($sql) {
  $db = new MyDB();
  if (!$db) {
    echo $db->lastErrorMsg();
  } else {
    $ret = $db->query($sql);
    $lastId = $db->lastInsertRowid();
    return $lastId;
  }
}

function getLastRowId() {
  $db = new MyDB();
  if (!$db) {
    echo $db->lastErrorMsg();
  } else {
    $lastId = $db->lastInsertRowid();
    return $lastId;
  }
}

function printArrayResult($sql) {
  $records = getArrayResult($sql);
  foreach ($records as $record) {
    echo "<pre>";
    print_r($record);
    echo "</pre>";
  }
}

function getArrayResult($sql) {
  $db = new MyDB();
  if (!$db) {
    echo $db->lastErrorMsg();
  } else {
    $ret = $db->query($sql);
    $returnArray = array();
    while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
      array_push($returnArray, $row);
    }
    $db->close();
    return $returnArray;
  }
}

function getSingleColumnArray($sql , $column_name) {
  $ret = query($sql);
  $returnArray = array();
  while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
    array_push($returnArray, ($row[$column_name]));
  }
  return $returnArray;
}
?>
