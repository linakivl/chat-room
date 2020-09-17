<?php

    namespace Controllers;

    use PDO;
    class RoomController extends Core\Controller{

        public $needlogin = true;

        public function privateChat($chatId){
            $this->set([
                'chatId' => $chatId
            ]);

            $this->layout = "room";
            $this->render("roomIndex");

        }

        public function sendRoomText(){

            $result = \Models\Messages::setNewPrivateMsg($_SESSION['id'], $_POST['chatUserId'], $_POST['sendText']);

            echo $result;
        }


    }




?>