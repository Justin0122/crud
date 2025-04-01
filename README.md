## Setting up

### Dependencies
This package requires the following dependencies:
- [Laravel Livewire](https://livewire.laravel.com/docs/quickstart)
- [Tailwind CSS](https://tailwindcss.com/docs/installation)
- [Flux](https://fluxui.dev/)

### Pre-requisites
To install the package, you need to set the minimum stability to dev in the composer.json file:
```json
{
...
    "minimum-stability": "dev",
    "prefer-stable": true
}
```

### Installation


```bash
composer require justin0122/crud
```


### Configuration

Add the service provider to the bootstrap/providers.php file:
```php
# config/app.php

'providers' => [
    ...
    \Justin0122\Crud\CrudServiceProvider::class,
    ...
],
```

## Usage:
To generate a crud, run the following command:
```bash
php artisan crud:make Post
```
  <summary><i>Post is the name of the model.</i></summary>

This will generate the following files:
```
app/Livewire/Post.php
app/Livewire/Posts.php
app/Models/Post.php

database/migrations/2021_01_01_000000_create_posts_table.php

resources/views/livewire/posts/index.blade.php
resources/views/livewire/crud/create.blade.php
resources/views/livewire/crud/edit.blade.php
```
<details>
  <summary>Details</summary>

### Forms
The forms are created using the `$fillables` array in the model. If you want to add more fields, just add them to the array in the model.

### Views
Because the forms are generated dynamically, they are made <span style="color:orange">global</span>. This means that you can use them in other views as well. The views are located in the `resources/views/livewire/crud` folder.
</details>

## Adding the fillable fields

To make the crud work, you need to add the fillable fields in the model:
```php
# app/Models/Post.php

protected $fillable = [
    'title',
    'body',
];
```

## Adding the routes
Add the routes in the web.php file:
```php
# routes/web.php

use App\Http\Livewire\Post;

    Route::get('/post', fn() => view('post'))->name('post');

    Route::delete('/post/{id}', fn($id) => redirect()->route('post'))->name('post.delete');

    Route::get('/post?id={id}', fn($id) => view('post'))->name('post.edit');
```

## Adding the Livewire component
Add the Livewire component to the view:
```html
<!-- resources/views/post.blade.php -->

<x-layouts.app :title="__('Posts')">
    <livewire:post />
</x-layouts.app>
```

## Displaying the Posts
```html
<!-- resources/views/livewires/posts/index.blade.php -->

<x-table :results="$results" :type="post" :crud="true" :fillables="$fillables"/>


```
