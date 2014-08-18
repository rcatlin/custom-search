# Google Custom Search Library

## IN DEVELOPMENT

Access Custom Search Engine and Autocomplete APIs

[Custom Search Documentation](https://developers.google.com/custom-search/json-api/v1/overview)
[Custom Search Performance Tips](https://developers.google.com/custom-search/json-api/v1/performance)
Usage:
=====
```php
<?php

require_once(__DIR__.'/vendor/autoload.php');

use RCatlin\CustomSearch\Manager;

$cx = "your-custom-search-id";
$apiKey = "your-api-key";

$manager = new Manager($cx, array($apiKey));

$searchTerms = "carcharodon carcharias";

// Get Search Results array
$result = $manager->search(searchTerms);

// Get Autocompletions
$autocompletions = $manager->autocomplete($searchTerms);

```
