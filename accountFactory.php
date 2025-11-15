<?
require_once("db.php");

class Account
{
    protected $db;
    public $id;
    public $username;
    public $role;

    public function __construct($n_db, $n_id, $n_username, $n_role)
    {
        $this->db = $n_db;
        $this->id = $n_id;
        $this->username = $n_username;
        $this->role = $n_role;
    }
}

class Player extends Account
{
    ///not sure if we will have any player specific functions
}

class Moderator extends Account
{
    public function ban($ban_username)
    {
        // look for the username 
        $result = $this->db->query("SELECT username FROM accounts WHERE username='$ban_username'");
        $match = $result->fetch();
        //ban
    }
}

class AccountFactory
{
    public static function createAccount($n_db, $n_id, $n_username, $n_role)
    {
        switch ($n_role) {
            case "Moderator":
                return new Moderator($n_db, $n_id, $n_username, $n_role);

            case "Player":
                return new Player($n_db, $n_id, $n_username, $n_role);
        }
    }
}

?>