<?php

class Audience
{
    private $userId;
    private $tickets;
    private $paymentType;
}

class Event
{
    private $eventId;
    private $eventName;
    private $eventStartDate;
    private $eventEndDate;
}

class Ticket
{
    private $events;
    private $ticketId;
    private $ticketName;
    private $ticketUserId;
    private $ticketStatus;
    private $ticketCreated;
    private $isUsed;
    //public function getTicketsForEvent($eventId){}
    //public function getTicketsForEventAndUserIdAndDate(){}
    //public function isUsedTicket($ticketId) {}
}
class Contract
{
    private $contractId;
    private $userId;
    private $paymentType;
    private $amount;
    private $change;
    private $quantity;
    private $created;
}

class Sales
{
    private $salesId;
    private $contractId;
    private $eventId;
    private $userId;
}

class Sales_Status
{
    private $salesId;
    private $salesStatus;
    private $created;
    private $modified;
}
