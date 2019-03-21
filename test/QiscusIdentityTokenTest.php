<?php

// require "vendor/autoload.php";
// // require "src/Qiscus/QiscusSdk.php";
// require "src/Qiscus/QiscusIdentityToken.php";

// $qiscus_identity_token = new \Qiscus\QiscusIdentityToken("dragongo", "dragongo-123");
// // $qiscus_identity_token->localMode(true);
// $nonce = $qiscus_identity_token->getNonce();
// // var_dump($nonce);

// // get nonce
// $nonce = $nonce->results->nonce;

// var_dump($nonce);

// // now build identity token (client's server)
// $email = "email-sdk-qiscus-tester@mailinator.com";
// $name = "Tester SDK using client auth";
// $avatar_url = "https://res.cloudinary.com/qiscus/image/upload/v1501313707/group_avatar_kiwari-prod_user_id_72/abzgeaglfyeb2oujq5bb.jpg";

// $identity_token = $qiscus_identity_token->generateIdentityToken($nonce, $email, $name, $avatar_url);

// var_dump($identity_token);

// // then call verify identity token
// $verified_user = $qiscus_identity_token->verifyIdentityToken($identity_token);

// var_dump($verified_user);
