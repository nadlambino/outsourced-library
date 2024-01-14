# Outsourced Technical Exam
<hr>

## About

The application is based around two Libraries. Each library will have books that they can borrow to
their users, who can register online to become associated to their library. The application should
allow books to be tracked as either available or out with a user (so unavailable to borrow for
other users).
<hr>

## Setup

Run migrations and seeders
```bash
php artisan migrate:fresh --seed
```

Serve the application
```bash
php artisan serve
```

For `forgot password`, use mailtrap and add the configs to `.env`

If there is something wrong with the UI, run `npm run build`
