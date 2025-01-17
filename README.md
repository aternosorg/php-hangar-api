# Aternos/php-hangar-api
An API client for the Hangar API written in PHP. This client is a combination of
code generated by OpenAPI Generator and some wrappers around it to improve the
usability.

The generated code can be found in `lib/Api` and `lib/Model`. It is recommended
to use the Wrappers in `lib/Client` instead of the generated code.

## Installation
Install the package via composer:
```bash
composer require aternos/hangar-api
```

## Usage

The main entry point for the API is the `HangarAPIClient` class.
```php
<?php
use Aternos\HangarApi\Client\HangarAPIClient;

// create an API client. This is the main entry point for the API
$hangarClient = new HangarAPIClient();

// set a user agent (recommended)
$hangarClient->setUserAgent('aternos/php-hangar-api-example');

// set an api key (optional)
$hangarClient->setApiKey("api-key");
```
The API Key is only required for non-public requests but if it is provided, it will be used for all requests.

## Result Lists
Most methods return a paginated result list which contains a list of results on the current page and methods to
navigate to the next and previous page. The result list implements `Iterator`, `ArrayAccess` and `Countable` so
you can use it like an array. It also has a `getResults()` method which returns the underlying array of results.

### Searching for Projects
```php
$projects = $hangarClient->getProjects();

foreach ($project as $project) {
    // like most other methods, this method returns a wrapper
    // you can use the getData() method to get the project data
    echo $project->getData()->getName() . PHP_EOL;
}

$projects = $projects->getNextPage();

foreach ($projects as $project) {
    echo $project->getData()->getName() . PHP_EOL;
}
```

### Search for Projects with Options
You can apply filters and change the sort order when searching for projects.
All options are optional and can be combined.
```php
use \Aternos\HangarApi\Client\Options\ProjectSearch\ProjectSearchOptions;
use \Aternos\HangarApi\Client\Options\ProjectCategory;
use \Aternos\HangarApi\Client\Options\ProjectSearch\ProjectSortField;

$options = new ProjectSearchOptions();
$options->setCategory(ProjectCategory::ADMIN_TOOLS);
$options->setQuery("mclogs");
$options->setSortField(ProjectSortField::UPDATED);
$projects = $hangarClient->getProjects($options);
```

## Getting Additional Project Data
The Project wrapper provides methods to fetch additional data about the project.
```php
// get a specific project
$project = $hangarClient->getProject("mclogs");

// get versions of the project (paginated)
$versions = $project->getVersions();

// get a specific version
$version = $project->getVersion("2.6.2");

// get the owner of the project
$owner = $project->getOwner();

// get the members of the project (paginated)
$members = $project->getMembers();

// get the people who starred the project (paginated)
$stargazers = $project->getStargazers();

// get the people who are watching the project (paginated)
$watchers = $project->getWatchers();
```

## Versions
```php
// get versions of a project by name (paginated)
$versions = $hangarClient->getProjectVersions("mclogs");

// get the versions from a project (paginated)
$versions = $project->getVersions();

// get a specific version of a project by name
$version = $hangarClient->getVersion("mclogs", "2.6.2");

// get a specific version of a project
$version = $project->getVersion("2.6.2");

// get the daily stats of the version
$stats = $version->getDailyStats();
foreach ($stats as $date => $stat) {
    echo $stat->getData()->getDownloads() . " Downloads and on " $date . PHP_EOL;
}
```

## Users
```php
// get a user
$user = $hangarClient->getUser("Aternos");

// get all projects of a user (paginated)
$projects = $user->getProjects();

// get the projects a user has starred (paginated)
$starredProjects = $user->getStarredProjects();

// get the projects a user is watching (paginated)
$watchedProjects = $user->getWatchedProjects();
```

## Project Pages
```php
// get the main page of a project
$page = $hangarClient->getProjectMainPage("mclogs");

// get other pages
$page = $hangarClient->getProjectPage("mclogs", "Config");

// get a page from a project
$page = $project->getPage("Config");

// edit a page
$page->setContent("New content");
$page->save();
```

## Updating the generated code
The generated code can be updated by installing the [openapi generator](https://openapi-generator.tech/docs/installation) running the following command:
```bash
openapi-generator-cli generate -c config.yaml
```
