<?php

namespace Moxl\Xec\Payload;

class Mood extends Payload
{
    public function handle($stanza, $parent = false)
    {
        $from = current(explode('/',(string)$parent->attributes()->from));

        if(isset($stanza->items->item->mood) && $stanza->items->item->mood->count() > 0) {
            $arrmood = array();
            foreach($stanza->items->item->mood->children() as $mood) {
                if($mood->getName() != 'text')
                    array_push($arrmood, $mood->getName());
            }

            if(count($arrmood) > 0) {
                $cd = new \Modl\ContactDAO;
                $c = $cd->get($from);

                if($c != null) {
                    $c->mood = $arrmood;
                    $cd->set($c);
                }
            }
        }
    }
}
