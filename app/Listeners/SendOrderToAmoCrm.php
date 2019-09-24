<?php

namespace App\Listeners;

use App\Events\NewOrderEvent;
use Dotzero\LaravelAmoCrm\AmoCrmManager;

class SendOrderToAmoCrm
{
    /**
     * @var AmoCrmManager
     */
    private $amocrm;
    private $lead;
    private $note;

    /**
     * Create the event listener.
     *
     * @param AmoCrmManager $amocrm
     */
    public function __construct(AmoCrmManager $amocrm)
    {
        $this->amocrm = $amocrm->getClient();
        $this->lead = $this->amocrm->lead;
        $this->note = $this->amocrm->note;
    }

    /**
     * Handle the event.
     *
     * @param  NewOrderEvent  $event
     * @return void
     */
    public function handle(NewOrderEvent $event)
    {
//        echo json_encode($event->order);
//        die;
        $lead = $this->lead;
        $lead['name'] = 'Новый заказ';
        $lead['price'] = $event->order->grand_total;
        $leadId = $lead->apiAdd();

        $note = $this->note;
        $note['element_id'] = $leadId;
        $note['element_type'] = \AmoCRM\Models\Note::TYPE_LEAD; // 1 - contact, 2 - lead
        $note['note_type'] = \AmoCRM\Models\Note::COMMON; // @see https://developers.amocrm.ru/rest_api/notes_type.php
        $note['text'] = view('AmoCrm.note-message', ['order' => $event->order])->render();

        $note->apiAdd();
    }
}
