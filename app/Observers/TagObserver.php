<?php

namespace App\Observers;

use App\Tag;

class TagObserver
{
    /**
     * Handle the tag "deleting" event.
     *
     * @param  \App\Tag  $tag
     * @return void
     */
    public function deleting(Tag $tag)
    {
        foreach ($tag->meals as $meal) {
            if ($meal->tags->count() == 1) {
                $meal->forceDelete();
            }
        }
    }
}
