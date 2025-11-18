<?
require_once("db.php");

class Account
{
    public $id;
    public $username;
    public $display_name;
    public $role;
    public $banned;

    public function __construct($n_id, $n_username, $n_display_name, $n_role, $n_banned)
    {
        $this->id = $n_id;
        $this->username = $n_username;
        $this->display_name = $n_display_name;
        $this->role = $n_role;
        $this->banned = $n_banned;
    }
}

class Player extends Account
{
    ///not sure if we will have any player specific functions
}

class Moderator extends Account
{
    public function ban($db, $ban_username)
    {
        // look for the username 
        $result = $db->query("SELECT display_name FROM accounts WHERE display_name='$ban_username'");
        $match = $result->fetch();
        //ban
    }
}

class AccountFactory
{
    public static function createAccount($n_id, $n_username, $n_display_name, $n_role, $n_banned)
    {
        switch ($n_role) {
            case "Moderator":
                return new Moderator($n_id, $n_username, $n_display_name, $n_role, $n_banned);

            case "Player":
                return new Player($n_id, $n_username, $n_display_name, $n_role, $n_banned);
        }
    }
}

?>