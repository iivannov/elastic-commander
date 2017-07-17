# Elastic Commander

This a simple and easy to use wrapper for the official low-level Elasticsearch PHP Client.

It simplifies the work with Elasticsearch API by offering a lot of helper methods for managing indices, adding and updating documents and searching the index.


----------

# Installation

Via Composer

```
$composer require iivannov/elastic-commander
```

----------

# Usage

## Initialization

Minimum required (will work with default host - localhost:9200)
```
$commander = new Commander('YourIndexName');
```

With a list of hosts
```
$hosts = [
    '192.168.1.1:9200',         // IP + Port
    '192.168.1.2',              // Just IP
    'mydomain.server.com:9201', // Domain + Port
    'mydomain2.server.com',     // Just Domain
    'https://localhost',        // SSL to localhost
    'https://192.168.1.3:9200'  // SSL to IP + Port
];

$commander = new Commander('YourIndexName', $hosts);
```


With a custom handler
```
$handler = new MyCustomHandler();
$commander = new Commander('YourIndexName', $hosts, $handler);
```


N.B. Each instance of the Commander works with the index name specified when initializing it. All actions and queries will be executed on this index.
If you want to set a new index name to work with use:

```
$commander->reset('NewIndexName');
```


## Index


### 1. Create the index
 
```
$commander->index()->create();
```

### 2. Delete the index
```
$commander->index()->delete();
```

### 3. Reset the index

A helper method that will reset the index by deleting it and creating it again.
```
$commander->index()->reset();
```

### 4. Optimize the index
// Not finished
```
$commander->index()->optimize();
```

### 5. Statistics about the index
// Not finished
```
$commander->index()->stats();
```

----------


## Mapping

### 1. Put Mapping 
```
$commander->mapping($mapping);
```

----------

## Document


### 1. Check if document exists by id

```
$commander->document('SomeDocumentType')->exists($id);
```

### 2. Get document by id

```
$commander->document('SomeDocumentType')->get($id);
```

### 3. Add document

In current version  the add method expects an ID for the document.
```
$commander->document('SomeDocumentType')->add($id, $parameters);
```

### 4. Update document

```
$commander->document('SomeDocumentType')->add($id, $parameters);
```


----------


## Search

Searching is done by passing a raw query array or by using a custom criteria class.
After the query you have the option to get: the full response, only the ids, a map of the results or the total count.

### 1. Raw Query

```
$result = $commander->search('SomeDocumentType')->query($query, $sort, $size, $from);
```

### 2. Criteria Query

```
$result = $commander->search('SomeDocumentType')->criteria($criteria);
```

## Result

After running either a raw query or one with a criteria class you can use one of the helper methods for manipulating the result response.

### 1. Return ElasticSearch raw response
```
$result->response();
```

### 2. Return total number of results
```
$result->total();
```

### 3. Return an array of IDs for the found hits 
```
$result->ids();
```

### 3. Return an array of objects for the found hits
The key will be the _id of the hit and the value will be an stdClass of the _source
```
$result->hits();
```


----------

## Count
// Not finished