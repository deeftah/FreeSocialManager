<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\PublishRequest as StoreRequest;
use App\Http\Requests\PublishRequest as UpdateRequest;

class PublishCrudController extends CrudController
{
    public function setup()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Publish');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/publish');
        $this->crud->setEntityNameStrings('publish', 'publish');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        $this->crud->setFromDb();

        // ------ CRUD FIELDS
        // $this->crud->addField($options, 'update/create/both');
        // $this->crud->addFields($array_of_arrays, 'update/create/both');
        // $this->crud->removeField('name', 'update/create/both');
        // $this->crud->removeFields($array_of_names, 'update/create/both');

        $this->crud->removeField('published', 'update/create/both');
        $this->crud->addField([
            'label' => "Client Accounts",
            'type' => 'select2_multiple',
            'name' => 'clientAccounts', // the method that defines the relationship in your Model
            'entity' => 'clientAccounts', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => 'App\Models\ClientAccount', // foreign key model
            'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
        ]);
        $this->crud->addField([
            'name' => 'status',
            'label' => 'Active',
            'type' => 'checkbox'
        ]);
        $this->crud->addField([
            'name' => 'datetime',
            'label' => 'Date & Time',
            'type' => 'datetime_picker',
            'datetime_picker_options' => [
                'format' => 'DD/MM/YYYY HH:mm',
                'language' => 'en',
            ]
        ]);
        $this->crud->addField([
            'label' => "Image",
            'name' => "image",
            'type' => 'image',
            'upload' => true,
            'crop' => false,
            'prefix' => 'uploads' // in case you only store the filename in the database, this text will be prepended to the database value
        ]);
        $this->crud->addField([  // Select2
            'label' => "Tag Group",
            'type' => 'select2',
            'name' => 'tag_group_id', // the db column for the foreign key
            'entity' => 'tagGroup', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => 'App\Models\TagGroup' // foreign key model
        ]);


        // ------ CRUD COLUMNS
        // $this->crud->addColumn(); // add a single column, at the end of the stack
        // $this->crud->addColumns(); // add multiple columns, at the end of the stack
        // $this->crud->removeColumn('column_name'); // remove a column from the stack
        // $this->crud->removeColumns(['column_name_1', 'column_name_2']); // remove an array of columns from the stack
        // $this->crud->setColumnDetails('column_name', ['attribute' => 'value']); // adjusts the properties of the passed in column (by name)
        // $this->crud->setColumnsDetails(['column_1', 'column_2'], ['attribute' => 'value']);

        $this->crud->removeColumns(['description']);
        $this->crud->setColumnDetails('image', [
            'label' => "Image", // Table column heading
            'type' => 'image',
            'prefix' => '/uploads/',
            'height' => '100px'
        ]);
        $this->crud->setColumnDetails('status', [
            'label' => 'Active',
            'type' => 'boolean',
        ]);
        $this->crud->setColumnDetails('tag_group_id', [
            'label' => "Tag Group", // Table column heading
            'type' => "select",
            'name' => 'tag_group_id', // the column that contains the ID of that connected entity;
            'entity' => 'tagGroup', // the method that defines the relationship in your Model
            'attribute' => "name", // foreign key attribute that is shown to user
            'model' => 'App\Models\TagGroup', // foreign key model
        ]);
        $this->crud->setColumnDetails('published', [
            'label' => 'Published',
            'type' => 'boolean',
        ]);

        // ------ CRUD BUTTONS
        // possible positions: 'beginning' and 'end'; defaults to 'beginning' for the 'line' stack, 'end' for the others;
        // $this->crud->addButton($stack, $name, $type, $content, $position); // add a button; possible types are: view, model_function
        // $this->crud->addButtonFromModelFunction($stack, $name, $model_function_name, $position); // add a button whose HTML is returned by a method in the CRUD model
        // $this->crud->addButtonFromView($stack, $name, $view, $position); // add a button whose HTML is in a view placed at resources\views\vendor\backpack\crud\buttons
        // $this->crud->removeButton($name);
        // $this->crud->removeButtonFromStack($name, $stack);
        // $this->crud->removeAllButtons();
        // $this->crud->removeAllButtonsFromStack('line');

        // ------ CRUD ACCESS
        // $this->crud->allowAccess(['list', 'create', 'update', 'reorder', 'delete']);
        // $this->crud->denyAccess(['list', 'create', 'update', 'reorder', 'delete']);

        // ------ CRUD REORDER
        // $this->crud->enableReorder('label_name', MAX_TREE_LEVEL);
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('reorder');

        // ------ CRUD DETAILS ROW
        // $this->crud->enableDetailsRow();
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('details_row');
        // NOTE: you also need to do overwrite the showDetailsRow($id) method in your EntityCrudController to show whatever you'd like in the details row OR overwrite the views/backpack/crud/details_row.blade.php

        // ------ REVISIONS
        // You also need to use \Venturecraft\Revisionable\RevisionableTrait;
        // Please check out: https://laravel-backpack.readme.io/docs/crud#revisions
        // $this->crud->allowAccess('revisions');

        // ------ AJAX TABLE VIEW
        // Please note the drawbacks of this though:
        // - 1-n and n-n columns are not searchable
        // - date and datetime columns won't be sortable anymore
        $this->crud->enableAjaxTable();

        // ------ DATATABLE EXPORT BUTTONS
        // Show export to PDF, CSV, XLS and Print buttons on the table view.
        // Does not work well with AJAX datatables.
        $this->crud->enableExportButtons();

        // ------ ADVANCED QUERIES
        // $this->crud->addClause('active');
        // $this->crud->addClause('type', 'car');
        // $this->crud->addClause('where', 'name', '==', 'car');
        // $this->crud->addClause('whereName', 'car');
        // $this->crud->addClause('whereHas', 'posts', function($query) {
        //     $query->activePosts();
        // });
        // $this->crud->addClause('withoutGlobalScopes');
        // $this->crud->addClause('withoutGlobalScope', VisibleScope::class);
        // $this->crud->with(); // eager load relationships
//        $this->crud->orderBy();
        // $this->crud->groupBy();
//         $this->crud->limit();

        $this->crud->addFilter([ // select2 filter
            'name' => 'status',
            'type' => 'select2',
            'label' => 'Status'
        ], function () {
            return [
                1 => 'Active',
                2 => 'Inactive'
            ];
        }, function ($value) { // if the filter is active
            $this->crud->addClause('where', 'status', $value);
        });

        $this->crud->addFilter([ // select2 filter
            'name' => 'published',
            'type' => 'select2',
            'label' => 'Published Status'
        ], function () {
            return [
                0 => 'Not yet published',
                1 => 'Published'
            ];
        }, function ($value) { // if the filter is active
            $this->crud->addClause('where', 'published', $value);
        });

        $this->crud->addFilter([ // daterange filter
            'type' => 'date_range',
            'name' => 'from_to',
            'label' => 'Date range'
        ],
            false,
            function ($value) { // if the filter is active, apply these constraints
                $dates = json_decode($value);
                $this->crud->query = $this->crud->query->dateBigger($dates->from);
                $this->crud->query = $this->crud->query->dateSmaller($dates->to);
            });

        $this->crud->addFilter([
            'type' => 'simple',
            'name' => 'trashed',
            'label' => 'Trashed'
        ],
            false,
            function () { // if the filter is active
                $this->crud->query = $this->crud->query->onlyTrashed();
            });

        $this->crud->filters(); // gets all the filters
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
