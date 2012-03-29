# Sirportly PHP API

This library allows you to interact with your Sirportly data using PHP.

## Setting up a Sirportly Client

```php
$sirportly = new Sirportly('the-token','the-secret');
```

## Creating a ticket

You can create tickets within your Sirportly system with a few commands. It's important to note that
creating a new ticket is a two step process - firstly, you need to create a `Ticket` record and then
you need to post your initial update using `post_update` on your newly created ticket.

```php
# Create the skeleton ticket
$properties = array(
    'brand' => 'Sirportly', 
    'department' => 'Sales Enquiries',
    'status' => 'New',
    'priority' => 'Normal',
    'subject' => 'A new sales enquiry',
    'name' => 'My New Customer',
    'email' => 'customer@atechmedia.com',
    );
    
  $ticket = $sirportly->create_ticket($properties);

# Now add the first update to this ticket
$update = $sirportly->post_update(array('ticket' => $ticket['reference'], 'message' => 'I would like some more info about your product', 'customer' => $ticket['customer']['id'] ));
```

If an error occurs, you will receive an array of errors. There are many
other properties which can be passed to the `create_ticket` method which are not documented here. Take
a look at the [API documentation](http://www.sirportly.com/docs/api-specification/tickets/submitting-a-new-ticket)
for more information about the options available.

## Accessing Tickets

```php
$sirportly->tickets();                   
$sirportly->ticket(array('reference' => 'AB-123123');      
```

## Changing ticket properties

If you wish to change properties of a ticket, you can use `update_ticket`. This function behaves
exactly the same as the corresponding API method and further details can be found in the 
[documentation](https://atech.sirportly.com/knowledge/4/api-specification/tickets/changing-ticket-properties). 


```PHP
# Change a ticket status
$sirportly->update_ticket(array('ticket' => 'GI-857090', 'status' => 'waiting for staff'));

# Change a ticket priority
$sirportly->update_ticket(array('ticket' => 'GI-857090', 'priority' => 'low'));

# Change multiple attributes
$sirportly->update_ticket(array('ticket' => 'GI-857090', 'team' => '1st line support', 'user => 'dave'));
```

Once an update has been carried out, the original ticket object will be updated to include the new properties.

## Posting updates to tickets

Posting updates to tickets is a simple affair and the `post_update` function will accept the same parameters as defined in the [documentation](http://www.sirportly.com/docs/api-specification/tickets/posting-an-update).

```php
# To post a system message without a user
$sirportly->post_update(array('ticket' => 'GI-857090', 'message' => 'My Example Message' ));

# To post an update as the ticket customer
$sirportly->post_update(array('ticket' => 'GI-857090', 'message' => 'My Example Message', 'customer' => 'Daniel' ));

# To post an update as a user
$sirportly->post_update(array('ticket' => 'GI-857090', 'message' => 'My Example Message', :user => 'Daniel')

# To post a private update as a user
$sirportly->post_update(array('ticket' => 'GI-857090', 'message' => 'Private Msg', 'user' => 'Daniel', 'private' => true ));

```

## Executing Macros

If you wish to execute one of your macros on a ticket, you can use the `run_macro` function
which accepts the ID or name of the macro you wish to execute. If executed successfully,
it will return true and the original ticket properties will be updated. 

```php
$sirportly->run_macro( array('ticket' => 'GI-857090', 'macro' => 'Mark as waiting for staff') );
````

## Adding follow ups

Adding to follow ups to tickets can be achieved by executing the `add_follow_up`function.

```php
$sirportly->add_follow_up( array('ticket' => 'GI-857090', 'actor' => 'Daniel', 'status' => 'resolved', 'run_at' => 'yyyy-mm-dd hh-mm') );
```

The `run_at` attribute should be a timestamp as outlined on our
[date/time formatting page](http://www.sirportly.com/docs/api-specification/date-time-formatting) in 
the API documentation.

## Creating a user

You can create users (staff members) via the API.

```php
$user_properties = array(
    'first_name' => 'John', 
    'first_name' => 'Particle', 
    'email_address' => 'john@testcompany.com', 
    'admin_access' => true, 
    );

$sirportly->create_user($user_properties);
```

There are other attributes available, which can be viewed on the [API docs](http://www.sirportly.com/docs/api-specification/users/create-new-user).

You do not need to create individual customers. These are created automatically on ticket and ticket update creation.

## Accessing Static Data Objects

The Sirportly API provides access to all the data objects stored in your Sirportly database.
At the current time, these cannot be edited through the API. 

```PHP
$sirportly->statuses();
$sirportly->priorities();
$sirportly->brands();
$sirportly->users();
$sirportly->customers();
```

You can access the following objects using this method: brands, departments, escalation_paths,
filters, priorities, slas, statuses, teams and users.

## Executing SPQL queries

Sirportly includes a powerful query language called SPQL (SirPortly Query Language) which allows you
to query your ticket data through the API. This is primarily used to generate reports however can also
be used to return data for your own purposes.

```PHP
$sirportly->spql(array('spql' => 'SELECT COUNT, status.name FROM tickets GROUP BY status.name'));
```