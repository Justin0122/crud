## Setting up

### Dependencies
This package requires the following dependencies:
- [Laravel Livewire](https://livewire.laravel.com/docs/quickstart)
- [Tailwind CSS](https://tailwindcss.com/docs/installation)

### Installation

<details>
  <summary><b>Composer</b></summary>

```bash
composer require justin0122/crud
```
</details>

<details>
  <summary><b>Zip(folder)</b></summary>

Copy the packages directory to the root of your project.
Add:
```json
//composer.json

    "require": {

    ...

    "justin0122/crud": "*"
    },

    ...

    "minimum-stability": "dev",
    "prefer-stable": true,
    "repositories": [
        {
            "type": "path",
            "url": "packages/justin0122/crud"
        }
    ],
]
```
Run:
```bash
composer dump-autoload
composer update
```

</details>

Add the service provider to the config/app.php file:
```php
# config/app.php

'providers' => [
    ...
    \Justin\Crud\CrudServiceProvider::class,
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

Route::get(
    '/post',
    function () {
        return view('post');
    }
)->name('post');
```

## Adding the Livewire component
Add the Livewire component to the view:
```html
<!-- resources/views/post.blade.php -->

<livewire:post />
```

## Displaying the Posts
To display the Posts in the view, you can hardcode the fields you want to display, otherwise it will display the 2nd field in the fillable array as the title and the 3rd field as the description.
```html
<!-- resources/views/livewires/posts/index.blade.php -->

    @foreach($results as $result)
        <x-card
            :title="$result->title ?? ''"
            :title-classes="'text-2xl'"
            :description="Str::limit($result->body, 100) . '' ?? ''"
            :image="$result->image ?? 'https://placehold.co/1200x1200'"
            :button="['url' => '/post?id=' . $post->id, 'label' => 'View'] ?? ''"
            :deleteButton="['id' => $result->id] ?? ''"
        />
    @endforeach
```
  <summary><i>In this example, the title, body (description) and url are hardcoded.</i>
</summary>

<details>
  <summary><b>Default</b></summary>


```html
    @foreach($results as $result)
        @php
            $attributes = $result->getAttributes();
            $title = $attributes[array_keys($attributes)[1]];
            $body = $attributes[array_keys($attributes)[2]];
        @endphp
        <x-card
            :title="$title ?? ''"
            :title-classes="'text-2xl'"
            :description="Str::limit($body, 100) . '' ?? ''"
            :image="$result->image ?? 'https://placehold.co/1200x1200'"
            :button="['url' => url()->current() . '?id=' . $result->id, 'label' => 'View'] ?? ''"
            :deleteButton="['id' => $result->id] ?? ''"
        />
    @endforeach
```
</details>


