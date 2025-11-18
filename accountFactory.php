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
    public function ban($db, $ban_id)
    {
        // look for the username 
        $result = $db->query("SELECT account_id FROM accounts WHERE account_id='$ban_id'");
        // Checking for Database Errors
        if (!$result) {
            $db = null;
            header("Location: index.php");
            // Ban Function
        } else if ($row = $result->fetch()) {
            // Swaps the values between 0 and 1 which represents banned and unbanned, 0 being unbanned and 1 being banned
            $banUnban = $row['banned'] ? '0' : '1';
            // Updates the database
            $db->exec("UPDATE accounts SET banned = '$banUnban' WHERE account_id = '$ban_id'");
            // Returns you to the Moderator Page
            header("Location: mod.php");
            exit();
        }
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