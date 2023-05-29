<?php
use LDAP\Result;

function connect_to_db() {
    $db_host = 'localhost';
    $db_user = 'root';
    $db_password = '';
    $db_name = 'diario';

    $conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);

    if (!$conn) {
        die('Error connecting the database: ' . mysqli_connect_error());
    }

    return $conn;
}


function disconnect_from_db($conn) {
    mysqli_close($conn);
}

function get_diaries_by_user_id($conn, $user_id) {
    $sql = "SELECT * FROM diaries WHERE user_id = $user_id";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function get_entries_by_diary_id($conn, $diary_id){
    $sql = "SELECT * FROM entries WHERE diary_id = $diary_id";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function get_diary_by_id($conn, $diary_id) {
    $sql = "SELECT * FROM diaries WHERE id = $diary_id";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function get_entry_by_id($conn, $diary_id, $entry_id) {
    $sql = "SELECT * FROM entries WHERE id = $entry_id and diary_id = $diary_id";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function get_entry($conn, $entry_id) {
    $sql = "SELECT * FROM entries WHERE id = $entry_id";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function get_favorites_by_user_id($conn, $user_id) {
    $sql = "SELECT e.id, e.title, e.content, e.diary_id, e.created_at, e.updated_at
            FROM entries e
            JOIN favorites f ON e.id = f.entry_id
            WHERE f.user_id = $user_id;";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function add_diary($conn, $user_id, $title) {
    $user_id = $_SESSION["user_id"];
    $sql = "INSERT INTO diaries (user_id, title) VALUES ($user_id, '$title')";
    return $conn->query($sql);
}

function add_entry($conn, $diary_id, $title, $content) {
    $sql = "INSERT INTO entries (diary_id, title, content, created_at, updated_at) VALUES ('$diary_id', '$title', '$content', NOW(), NOW())";
    return $conn->query($sql);
}

function delete_diary($conn, $diary_id) {
    $sql = "DELETE FROM diaries WHERE id = $diary_id";
    mysqli_query($conn, $sql);
}

function delete_entry($conn, $entry_id) {
    $sql = "DELETE FROM entries WHERE id = $entry_id";
    mysqli_query($conn, $sql);
}

function delete_entries_by_diary_id($conn, $diary_id) {
    $sql = "DELETE FROM entries WHERE diary_id = $diary_id";
    mysqli_query($conn, $sql);
}

function modify_entry($conn, $entry_id, $title, $content) {
    $sql = "UPDATE entries SET updated_at = NOW(), title = '$title', content = '$content' WHERE id = $entry_id";
    mysqli_query($conn, $sql);
}


function modify_diary($conn, $diary_id, $title) {
    $sql = "UPDATE diaries SET title = '$title' WHERE id = $diary_id";
    mysqli_query($conn, $sql);
}

function verify_property_user_diary($conn, $user_id, $diary_id) {
    $sql = "SELECT * FROM diaries WHERE id = $diary_id AND user_id = $user_id";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function verify_property_diary_entry($conn, $diary_id, $entry_id ){
    $sql = "SELECT * FROM entries WHERE id = $entry_id AND diary_id = $diary_id";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function verify_property_user_entry($conn, $user_id, $entry_id){
    $sql = "SELECT * FROM entries e JOIN diaries d ON e.diary_id = d.id WHERE e.id = $entry_id AND d.user_id = $user_id";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function delete_diary_and_entries($conn, $diary_id){
    delete_entries_by_diary_id($conn, $diary_id);
    delete_diary($conn, $diary_id);
}

function verify_entry_in_favorites($conn, $entry_id, $user_id){
    $sql = "SELECT * FROM favorites WHERE entry_id = $entry_id AND user_id = $user_id";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function entry_in_favorites($conn, $entry_id){
    $sql = "SELECT * FROM favorites WHERE entry_id = $entry_id";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function add_entry_to_favorites($conn, $entry_id, $user_id){
    $sql = "INSERT INTO favorites (entry_id, user_id) VALUES ($entry_id, $user_id)";
    mysqli_query($conn, $sql);
}

function remove_entry_from_favorites($conn, $entry_id, $user_id){
    $sql = "DELETE FROM favorites WHERE entry_id = $entry_id AND user_id = $user_id";
    mysqli_query($conn, $sql);
}

function delete_diary_and_entries_by_user_id($conn, $user_id){
    $sql = "DELETE FROM entries WHERE diary_id = (SELECT id FROM diaries WHERE user_id = $user_id)";
    mysqli_query($conn, $sql);
    $sql = "DELETE FROM diaries WHERE user_id = $user_id";
    mysqli_query($conn, $sql);
}

function create_account($conn, $name, $last_name, $email, $hashed_password){
    $sql = "INSERT INTO users (name, last_name, email, password) VALUES ('$name', '$last_name', '$email', '$hashed_password')";
     return $conn->query($sql);  
}

function delete_account($conn, $user_id){

    delete_diary_and_entries_by_user_id($conn, $user_id);
    $sql = "DELETE FROM users WHERE id = $user_id";
    mysqli_query($conn, $sql);
    
}

?>

