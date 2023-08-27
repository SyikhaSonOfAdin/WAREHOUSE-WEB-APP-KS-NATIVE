<?php
class Connect {
    private $user = 'root' ;
    private $password = '' ;
    private $database = 'kokohsemesta' ;

    // TABLE 
    private $receiveTable = 'material_receive_hein' ;
    private $issuedTable = 'material_used_hein' ;
    
    public function receive() {
        return $conn = mysqli_connect("localhost", "$this->user", "$this->password", "$this->database");    
    }
}

function conn($user, $password, $database, $table)
{
    return $conn = mysqli_connect("localhost", "$user", "$password", "$database");
}

function selectAll($user, $password, $database, $table)
{
    //connect to database
    $conn = mysqli_connect("localhost", "$user", "$password", "$database");
    return $result = mysqli_query($conn, "SELECT * FROM `$table`");
}

function quoteString($string)
{
    $new_string = "";
    for ($i = 0; $i < strlen($string); $i++) {
        if ($string[$i] == "'") {
            $new_string .= "\\'";
        } else {
            $new_string .= $string[$i];
        }
    }
    return $new_string;
}

function tryCookie($username, $role)
{
    // Hash the string with the salt
    $user = hash("sha256", $username );
    $level = hash("sha256", $role );

    // Set the cookie
    setcookie("id", $user, time() + 302400, "/");
    setcookie("level", $level, time() + 302400, "/");

    // Return the hash
    return ;
}

function getCookie() 
{
    $getData = selectAll("root", "", "kokohsemesta", "login") ;
    while ($data = mysqli_fetch_assoc($getData)) {
        $user = hash("sha256", $data["username"] );
        $level = hash("sha256", $data["role"] ); 
        if (isset($_COOKIE["id"])) {
            if ($_COOKIE["id"] == $user && $_COOKIE["level"] == $level) {
                $_SESSION["name"] = $data["username"] ;
                $_SESSION["role"] = $data["role"] ;
                $_SESSION["login"] = true ;
                return ;
            }
        }

    }
}

function searchJson($data, $search) {
    $dataArray = json_decode($data, true); // Ubah JSON menjadi array asosiatif

    $searchResults = array();

    foreach ($dataArray as $data) {
        foreach ($data as $key => $value) {
            if (is_string($value) && strpos($value, $search) !== false) {
                // Jika value berupa string dan mengandung $search
                $searchResults[] = $data;
                break; // Keluar dari loop jika sudah ditemukan satu data yang cocok
            }
        }
    }

    return $searchResults;
}

function readJson(string $path) {
    $data = file_get_contents($path);
    return json_decode($data, true);
}