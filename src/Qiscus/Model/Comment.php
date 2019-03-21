<?php

namespace Qiscus\Model;

class Comment implements \JsonSerializable {
    public $id; //String
    public $type; //String
    public $message; //String
    public $payload; //object
    public $creator; //User
    public $room; //Room
    public $timestamp; //Date
    public $unix_timestamp; //int
    public $comment_before_id; //String
    public $disable_link_preview; //boolean
    public $unique_temp_id; //String

    public function jsonSerialize() {
      return get_object_vars($this);
    }

}
