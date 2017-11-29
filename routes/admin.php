<?php

// your CRUD resources and other admin routes here
CRUD::resource('client', 'ClientCrudController');
CRUD::resource('network', 'NetworkCrudController');
CRUD::resource('clientNetwork', 'ClientNetworkCrudController');
CRUD::resource('publish', 'PublishCrudController');
CRUD::resource('publishNetwork', 'PublishNetworkCrudController');