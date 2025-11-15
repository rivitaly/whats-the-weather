<?
class Account
{
    public $id;
    public $username;
    public $role;

    public function __construct($n_id, $n_username, $n_role)
    {
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
        //connect to db
        //query look for this user 
        //remove all leaderbaord info
        //remove account
        //somehow kick him off if logged in
    }
}

class AccountFactory
{
    public static function createAccount($n_id, $n_username, $n_role)
    {
        switch ($n_role) {

            case "Moderator":
                return new Moderator($n_id, $n_username, $n_role);

            case "Player":
                return new Player($n_id, $n_username, $n_role);

        }
    }
}

?>