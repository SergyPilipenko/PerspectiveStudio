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
    private $contact;

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
        $this->contact = $this->amocrm->contact;
    }

    /**
     * Handle the event.
     *
     * @param  NewOrderEvent  $event
     * @return void
     */
    public function handle(NewOrderEvent $event)
    {
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

        $contact = $this->amocrm->contact;
        $contacts = $this->amocrm->contact->apiList([]);
        $contactExists = $this->contactExists($contacts, $event->order->customer_phone);


        if(!count($contactExists)) {
            $contact['name'] = $event->order->customer_last_name.' '.$event->order->customer_first_name;
            $contact->addCustomField(467711, [
                [$event->order->customer_phone, 'MOB'],
            ]);
            $contact->addCustomField(467713, [
                [$event->order->customer_email, 'WORK'],
            ]);
            $contactId = $contact->apiAdd();
        } elseif (count($contactExists)  > 1) {
            foreach ($contactExists as $contactExist) {
                $contact['linked_leads_id'] = $leadId;
                $contact->apiUpdate($contactExist['id']);
                return;
            }
        } else {
            $contactId = array_shift($contactExists)['id'];
        }
        $contact['linked_leads_id'] = $leadId;
        $contact->apiUpdate($contactId);
    }

    public function contactExists($contacts, $phone)
    {
        $userContact = [];
        foreach ($contacts as $contact) {
            if(isset($contact['custom_fields']))
            {
                foreach ($contact['custom_fields'] as $key => $custom_field)
                {
                    if(isset($custom_field['code']) && $custom_field['code'] == 'PHONE') {
                        foreach ($custom_field['values'] as $value) {
                            if($value['value'] == $phone) {
                                $userContact[] = $contact;
                            }
                        }
                    };
                }
            }
        }

        return $userContact;

    }
}
