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
    

	public function __construct($token,$secret,$url='api.sirportly.com') {
		$this->token  = $token;
		$this->secret = $secret;
		$this->url    = $url;
	}
	
  private function query($action,$postdata=array()) {
  		$curl = curl_init();
  		$query_string = "";
      foreach ($postdata AS $k=>$v) $query_string .= "$k=".urlencode($v)."&";
  		$header = array('X-Auth-Token: '.$this->token, 'X-Auth-Secret: '.$this->secret);
  		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
   		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
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
      $query = $this->query('/api/v1/tickets/ticket',array('reference' => $ticket_reference));
      return $query;
    }
    
    public function create_ticket($params = array()) {
      $query = $this->query('/api/v1/tickets/submit',$params);
      return $query;
    }
    
    public function post_update($params = array()) {
      $query = $this->query('/api/v1/tickets/post_update',$params);
      return $query;
    }
    
    public function tickets($page = '1') {
      $query = $this->query('/api/v1/tickets/all',array('page' => $page));
      return $query;
    }
    
    public function update_ticket($params = array()) {
      $query = $this->query('/api/v1/tickets/update',$params);
      return $query;
    }
    
    public function run_macro($params = array()) {
      $query = $this->query('/api/v1/tickets/macro',$params);
      return $query;
    }
    
    public function add_follow_up($params = array()) {
      $query = $this->query('/api/v1/tickets/followup',$params);
      return $query;
    }
    
    public function create_user($params = array()) {
      $query = $this->query('/api/v1/users/create',$params);
      return $query;
    }
    
    public function statuses() {
      $query = $this->query('/api/v1/objects/statuses');
      return $query;
    }
    
    public function priorities() {
      $query = $this->query('/api/v1/objects/priorities');
      return $query;
    }
    
    public function teams() {
      $query = $this->query('/api/v1/objects/teams');
      return $query;
    }
    
    public function brands() {
      $query = $this->query('/api/v1/objects/brands');
      return $query;
    }
    
    public function departments() {
      $query = $this->query('/api/v1/objects/departments');
      return $query;
    }
    
    public function escalation_paths() {
      $query = $this->query('/api/v1/objects/escalation_paths');
      return $query;
    }
    
    public function slas() {
      $query = $this->query('/api/v1/objects/slas');
      return $query;
    }
    
    public function filters() {
      $query = $this->query('/api/v1/objects/filters');
      return $query;
    }
    
    public function spql($params = array()) {
      $query = $this->query('/api/v1/tickets/spql',$params);
      return $query;
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
   
}
?>