# Yousign API client v2 for PHP

Read Yousign doc first : https://dev.yousign.com/?version=latest

**Features** :
- Provide a wrapper for your Yousign API usage.
- Non-framework dependant.
- Token Authentication (provided by Yousign).
- Simple or advanced Yousign procedure usage.

**Warnings** :
- Only the main routes are implemented
- No buisness code is implemented, you have to do within your project.

# How to use - Creating a Yousign Client.

You should implement a ClientFactory in your code to load your own configuration (env and token) from a Yaml file for example.

### 1 - Create an Environment Object
```php
$environment = new Environment($env === 'prod' ? Environment::PROD : Environment::DEMO);
```

### 2 - Create an Authentication Object
```php
$auth = new Authentication($token);
```

### 3 - Create a ClientFactory Object using both the Environment and Authentication objects
```php
$factory = new ClientFactory($environnement, $authentication);
```

### 4 - Create a Client Object using the ClientFactory
```php
$client = $factory->createClient();
```

Note : you should store the Client in your class for later use. A single Client can be used multiple times.
Note 2 : the Client has a built-in Guzzle client, you don't need to create a new one.

### 5 - Using the Client in your buisness code
All the methods are called dynamically. Only the immplemented methods can be called.
You can find the list of available methods in Client.php

Here is an example for a new procedure :

```php
    ...
    'newProcedure' => [
        'endpoint' => Endpoint::PROCEDURE,
        'verb' => Endpoint::VERB_POST,
        'params' => null,
        'suffix' => null
    ],
    ...
```

```php
    $response = $this->client->newProcedure(
        [
            'name' => 'Name of my signature'
            'description' => 'Electronic signature for my documents'
            'start' => false
            'config' => [
                'webhook' => [
                    ...
                ]
            ]
        ]
    );

```
______________
