<?php

namespace Qiscus\Model;

class Room implements \JsonSerializable {

  public $id; // String
  public $channel_id; // String
  public $type; // String
  public $name; // String
  public $creator_email; // String
  public $avatar_url; // String
  public $unread_count; // int
  public $last_comment_id; // String
  public $last_comment_message; // String
  public $last_comment_timestamp; //DateTime
  public $participants; // array(User)
  public $comments; // Comment or array(Comment)

  public function jsonSerialize() {
    return get_object_vars($this);
  }

}
