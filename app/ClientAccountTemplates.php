<?php

namespace App;

trait ClientAccountTemplates
{
    /*
    |--------------------------------------------------------------------------
    | Account Templates for FSM
    |--------------------------------------------------------------------------
    |
    | Each page template has its own method, that define what fields should show up using the Backpack\CRUD API.
    | Use snake_case for naming and PageManager will make sure it looks pretty in the create/update form
    | template dropdown.
    |
    | Any fields defined here will show up after the standard page fields:
    | - page name (only seen by admins)
    */

    private function telegram()
    {
        $this->crud->addField([   // CustomHTML
            'name' => 'metas_separator',
            'type' => 'custom_html',
            'value' => '<br><h2>Extras</h2><hr>',
        ]);
        $this->crud->addField([
            'name' => 'channel_username',
            'label' => 'Channel Username (without @)',
            'fake' => true,
            'store_in' => 'metas',
        ]);
        $this->crud->addField([
            'name' => 'bot_username',
            'label' => 'Bot Username (without @)',
            'fake' => true,
            'store_in' => 'metas',
        ]);
        $this->crud->addField([
            'name' => 'bot_token',
            'label' => 'Bot Token',
            'fake' => true,
            'store_in' => 'metas',
        ]);
    }

    private function instagram()
    {
        $this->crud->addField([   // CustomHTML
            'name' => 'metas_separator',
            'type' => 'custom_html',
            'value' => '<br><h2>Extras</h2><hr>',
        ]);
        $this->crud->addField([
            'name' => 'username',
            'label' => 'Instagram Username (without @)',
            'fake' => true,
            'store_in' => 'metas',
        ]);
        $this->crud->addField([
            'name' => 'password',
            'type' => 'password',
            'label' => 'Instagram Password',
            'fake' => true,
            'store_in' => 'metas',
        ]);
    }
}
