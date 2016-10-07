# Elastic Commander

Simple and easy to use wrapper for the official Elasticsearch PHP Client.

----------

# Installation

Via Composer

```
$composer require iivannov/elastic-commander
```

----------

# Usage

## Initialization


```
// minimum required
$commander = new Commander('YourIndexName');

// with a list of hosts
$commander = new Commander('YourIndexName', $hosts);
```

----------

## Index

### 1. Create the index
```
$commander->index()->create()
```

### 2. Delete the index
```
$commander->index()->delete()
```

### 3. Reset the index

A helper method that will reset the index by deleting it and creating it again.
```
$commander->index()->reset()
```

### 4. Optimize the index
// Not finished
```
$commander->index()->optimize()
```

### 5. Statistics about the index
// Not finished
```
$commander->index()->stats()
```

----------

## Document


### 1. Check if document exists by id

```
$commander->document('SomeDocumentType')->exists($id)
```

### 2. Get document by id

```
$commander->document('SomeDocumentType')->get($id)
```

### 3. Add document

In current version  the add method expects an ID for the document.
```
$commander->document('SomeDocumentType')->add($id, $parameters)
```

### 4. Update document

```
$commander->document('SomeDocumentType')->add($id, $parameters)
```


----------


## Search

Searching is done by passing a raw query array or by using a custom criteria class.
After the query you have the option to get: the full response, only the ids, a map of the results or the total count.

### 1. Raw Query

```
$commander->search('SomeDocumentType')->query($query, $sort, $size, $from)
```

### 2. Criteria Query

```
$commander->search('SomeDocumentType')->criteria($criteria)
```
