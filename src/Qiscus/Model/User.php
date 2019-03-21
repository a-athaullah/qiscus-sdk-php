<?php

namespace Qiscus\Model;

class User implements \JsonSerializable {

  public $id;
  public $token;
  public $email;
  public $password;
  public $display_name;
  public $avatar_url;
  public $last_comment_read_id; // String
  public $last_comment_received_id; // String

  public function jsonSerialize() {
    return get_object_vars($this);
  }

}
