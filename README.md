# FreeSocialManager

The First Free Open Source Social Network Manager

# Installation

- Rename `.env.example` to `.env`
- Edit `.env` file according to your needs (mysql database must be filled)
- Install the required packages using composer `composer install` (app root)
- `chmod -R o+w` the `storage` and `bootstrap/cache` directories
- `php artisan migrate`

