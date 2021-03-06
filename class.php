<?php
/**
* Sirportly PHP API Library
* @see https://github.com/sirportly/php-library
* @version  1.0
*/
class Sirportly
{
  private $token;
  private $secret;
  private $url;

  public function __construct($token,$secret,$url='https://api.sirportly.com') {
    $this->token  = $token;
    $this->secret = $secret;
    $this->url    = $url;
  }

  private function query($action,$postdata=array()) {
    $curl = curl_init();
    $query_string = "";
    foreach ($postdata AS $k=>$v) $query_string .= "$k=".urlencode($v)."&";
    $header = array('X-Auth-Token: '.$this->token, 'X-Auth-Secret: '.$this->secret);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_URL, $this->url.$action);
    curl_setopt($curl, CURLOPT_BUFFERSIZE, 131072);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $query_string);
    curl_setopt($curl, CURLOPT_POST, 1);

    $result = curl_exec($curl);
    curl_close($curl);
    $decode = json_decode($result,true);
    return $decode;
  }

  public function ticket($ticket_reference) {
    return $this->query('/api/v1/tickets/ticket',array('reference' => $ticket_reference));
  }

  public function create_ticket($params = array()) {
    return $this->query('/api/v1/tickets/submit',$params);
  }

  public function post_update($params = array()) {
    return $this->query('/api/v1/tickets/post_update',$params);
  }

  public function tickets($page = '1') {
    return $this->query('/api/v1/tickets/all',array('page' => $page));
  }

  public function update_ticket($params = array()) {
    return $this->query('/api/v1/tickets/update',$params);
  }

  public function run_macro($params = array()) {
    return $this->query('/api/v1/tickets/macro',$params);
  }

  public function add_follow_up($params = array()) {
    return $this->query('/api/v1/tickets/followup',$params);
  }

  public function create_user($params = array()) {
    return $this->query('/api/v1/users/create',$params);
  }

  public function statuses() {
    return $this->query('/api/v1/objects/statuses');
  }

  public function priorities() {
    return $this->query('/api/v1/objects/priorities');
  }

  public function teams() {
    return $this->query('/api/v1/objects/teams');
  }

  public function brands() {
    return $this->query('/api/v1/objects/brands');
  }

  public function departments() {
    return $this->query('/api/v1/objects/departments');
  }

  public function escalation_paths() {
    return $this->query('/api/v1/objects/escalation_paths');
  }

  public function slas() {
    return $this->query('/api/v1/objects/slas');
  }

  public function filters() {
    return $this->query('/api/v1/objects/filters');
  }

  public function spql($params = array()) {
    return $this->query('/api/v1/tickets/spql',$params);
  }

  /**
  * Fetch a list of knowledgebases from your account
  * @return array list of knowledgebases in an array format.
  */
  public function kb_list() {
    return $this->query('/api/v1/knowledge/list');
  }

  /**
  * Return a single knowledgebase tree.
  * @param  int $kb_id The ID of the knowledgebase you want to load
  * @return array        The knowledgebase as an array.
  */
  public function kb($kb_id) {
    return $this->query('/api/v1/knowledge/tree', array('kb' => $kb_id));
  }

  /**
  * Fetch a list of users from your account
  * @return array        The users as an array.
  */
  public function users($page=1) {
    return $this->query('/api/v2/users/all', array('page' => $page));
  }

  /**
  * Fetch a list of contacts from your account
  * @return array        The contacts as an array.
  */
  public function contacts($page=1) {
    return $this->query('/api/v2/contacts/all', array('page' => $page));
  }

}
?>
