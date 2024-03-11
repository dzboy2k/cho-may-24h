<?php

namespace App\Repositories\Chat;

interface ChatInterface
{

    public function getContactByUserAndReceiver($user_id, $receiver_id);

    public function getById($id);

    public function store($request);

    public function update($request, $id);

    public function destroy($id);

    public function getContactByUserId($id);

    public function getChatByUserAndReceiver($id);

    public function push($receiver, $message);

    public function firstOrNewContact($request);

    public function getContactByReceiverId($id);

    public function storeAndPushMessage($request);

    public function newContact($request);

    public function readContact($contact_id);

    public function destroyContact($id);
}