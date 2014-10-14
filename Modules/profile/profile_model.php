<?php
// no direct access
defined('EMONCMS_EXEC') or die('Restricted access');

class Profile
{
    private $mysqli;

    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }
    
    public function save($userid, $profile_id, $data)
    {
        $userid = (int) $userid;
        $profile_id = (int) $profile_id;
        $data = preg_replace('/[^\w\s-.",:{}\[\]]/','',$data);

        $data = json_decode($data);

        // Dont save if json_Decode fails
        if ($data!=null) {

          $data = json_encode($data);
          $data = $this->mysqli->real_escape_string($data);

          $result = $this->mysqli->query("SELECT `profile_id` FROM profile WHERE `userid` = '$userid' AND `profile_id` = '$profile_id'");
          $row = $result->fetch_object();

          if (!$row)
          {
              $this->mysqli->query("INSERT INTO profile (`userid`, `profile_id`, `data`) VALUES ('$userid','$profile_id','$data')");
          }
          else
          {
              $this->mysqli->query("UPDATE profile SET `data` = '$data' WHERE `userid` = '$userid' AND `profile_id` = '$profile_id'");
          }
          return array('success'=>true);
        }
        else
        {
          return array('success'=>false);
        }
    }
    
    public function get($userid,$profile_id)
    {
        $userid = (int) $userid;
        $profile_id = (int) $profile_id;
        $result = $this->mysqli->query("SELECT `data` FROM profile WHERE `userid` = '$userid' AND `profile_id` = '$profile_id'");
        $row = $result->fetch_array();
        if ($row && $row['data']!=null) return json_decode($row['data']); else return '0';
    }
}
