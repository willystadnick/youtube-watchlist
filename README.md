# youtube-watchlist

Solution to [challenge](challenge.md).

## Requirements

Same as [Laravel's Server Requirements](https://laravel.com/docs/7.x/installation#server-requirements).

## Configuration

Copy the `.env.example` file and rename it to `.env`, changing the variables accordingly.

Set GOOGLE_DEVELOPER_KEY to the "API key" value from the "Access" tab of the [Google API Console](https://console.developers.google.com/). Please ensure that you have enabled the YouTube Data API for your project.

## Install

Use [Composer](https://getcomposer.org/) to install dependencies:

```
composer install
```

## Serve

Use [Artisan](https://laravel.com/docs/7.x/artisan) to serve locally:

```
php artisan serve
```

## Test

Use [Artisan](https://laravel.com/docs/7.x/testing#artisan-test-runner) to run tests:

```
php artisan test
```

Use [Dusk](https://laravel.com/docs/7.x/dusk) to run browser tests:

```
php artisan dusk
```

Remember to set `APP_URL=http://127.0.0.1:8000` on `.env` and [start the local server](#serve).

You may need to run `vendor/laravel/dusk/bin/chromedriver-linux` or update chromedriver version with `php artisan dusk:update` if the tests takes too long to respond or return error.

## Author

| [<img src="https://avatars2.githubusercontent.com/u/1824706?s=120&v=4" width=120><br><sub>@willystadnick</sub>](https://github.com/willystadnick) |
| :---: |
