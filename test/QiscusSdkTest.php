<?php

 require 'vendor/autoload.php';
 require 'src/Qiscus/QiscusSdk.php';

 $qiscus_sdk = new \Qiscus\QiscusSdk('check', 'rahasiabanget');
 $room_name = 'Testing...';
 $password = 'password';
 $emails = ['email1@mailinator.com', 'email2@mailinator.com', 'email3@mailinator.com', 'email4@mailinator.com'];
 $creator = $emails[0];
 $room_participants = [$creator, $emails[3]];


try {
    $user = $qiscus_sdk->loginOrRegister($creator, $password, $creator);
    echo "</br>================ LOGIN OR REGISTER =======================</br>";
    var_dump($user);
    $create_room = $qiscus_sdk->createRoom($room_name, $emails, $creator, '', ['name'=>'aji']);
    echo "</br>================ CREATE ROOM =======================</br>";
    var_dump($create_room);
    $room = $qiscus_sdk->getOrCreateRoomWithTarget([$creator, $emails[1]], ['name'=>'risan']);
    echo "</br>================ GetOrCreateRoomWithTarget =======================</br>";
    var_dump($room);
    $rooms_info = $qiscus_sdk->getRoomsInfo("check_admin@qismo.com", [73573]);
    echo "</br>================ GET ROOMS INFO =======================</br>";
    var_dump($rooms_info);
    $add_room_participants = $qiscus_sdk->addRoomParticipants($create_room->id, $emails);
    echo "</br>================ ADD PARTICIPANTS ==================</br>";
    var_dump($add_room_participants);
    $remove_room_participants = $qiscus_sdk->removeRoomParticipants($create_room->id, [$emails[2]]);
    echo "</br>================ REMOVE PARTICIPANTS ==================</br>";
    var_dump($remove_room_participants);
    $post_comment = $qiscus_sdk->postComment($creator, $create_room->id, 'Halo');
    echo "</br>================ POST COMMENT ======================</br>";
    var_dump($post_comment);
    $load_comments = $qiscus_sdk->loadComments($create_room->id);
    echo "</br>================ LOAD COMMENTS =====================</br>";
    var_dump($load_comments);
    $get_user_rooms = $qiscus_sdk->getUserRooms($creator, "single", "1", "2");
    echo "</br>================ GET USER ROOMS =====================</br>";
    var_dump($get_user_rooms);
    $get_user_profile = $qiscus_sdk->getUserProfile($creator);
    echo "</br>================ GET USER PROFILE =====================</br>";
    var_dump($get_user_profile);
    $post_comment = $qiscus_sdk->postComment($creator, $create_room->id, 'Halo','buttons',
        array(
            'text'=>'silahkan pencet',
            'buttons'=>[
                [
                    "label"=>"button1"
                ]
            ]
        )
    );
    echo "</br>================ POST COMMENT BUTTON======================</br>";
    var_dump($post_comment);
}
catch (\Exception $e){
    var_dump($e->getMessage());
}
