# Hollatags Task

## The Problem
- An application for billing 10,000 users over a given billing API (owned by a third
party e.g. Telco/Bank).
- The billing API takes 1.6secs to process and respond to each request
- The details of the users to bill is stored in a Database with fields: id, username, mobile_number and amount_to_bill

*Reuirements: Write or describe a simple PHP code that will be able bill all the 10,000 users within 1hr.*

*Also suggest an approach to scale the above if you need to bill 100,000 users within 4.5hrs*

## Assumptions
1. We have the required user data. I have created a seeder to populate the database. The number of users needed can be updated in the `.env` file by changing the value of `SEED_USERS_NUMBER`
2. The billing is run as a cron job and so I have created a scheduler in `App\Console\Kernel` to run the billing command (`App\Console\Commands\BillingCommand`) daily.
3. Multiple APIs can be used. I created a Billing Service (`App\Services\Billing\Billing`) that can accept different drivers for different third party APIs to bill users. The current setup uses a Mock Driver (`App\Services\Billing\Drivers\Mock\MockBiller`) that delays for `1.6s` before responding to simulate values given in the task.
4. The 3rd Party APIs require only the user's mobile number and amount to bill a user.
5. The script would be run on a server with at least 2GB RAM

## Setting Up
### ENV
Update the following data in the `.env` file:
1. `SEED_USERS_NUMBER` - For the number of users to be seeded
2. `DB_DATABASE` - Name of database
3. `DB_USERNAME` - Username of database user
4. `DB_PASSWORD` - Password for database user
### Dependencies
This project uses Redis to queue jobs. So make sure you have redis installed and is running on port `6379`. If your redis is running on a custom port then update the redis port (`REDIS_PORT`) in the `.env` file.
### Composer
run `composer install` to install necessary libraries
### Artisan
Finally run the following:
1. `php artisan key:generate`
2. `php artisan migrate:fresh --seed`

In order to process the number of rows within the time stated in the task, we need to run at least 5 queue workers to run jobs concurrently. So, run the following command 5 times:
`php artisan queue:work &`

OR you can use [Supervisor](https://http://www.supervisord.org/index.html) to set up the queue workers.

## Suggestions
The current solution makes use of Redis to schedule jobs and process them via a worker. Currently, 5 workers are used to executed the task in less than 1 hour.

If the rows are increased to 100,000 and need to be executed in 4.5 hours then at least 10 workers will have to be used.

So, to scale the speed of our application, we only need to increase the number of workers so that more jobs can be handled concurrently. 

Justification:

`1 job = 1.6s`

hence, `100,000 jobs  = 160,000s`

With 10 workers, each worker would handle 16,000 jobs

`160,000s/10 = 16,000s`

`16,000s = 4.444 hours`

The server's capacity would have to be taken into consideration to ensure that it can handle the number of workers needed to process the job fast enough.

## Testing
To run the tests I have set up in `Tests\Unit`, run:

`./vendor/bin/phpunit`

The above command must be run from the root folder of this project.

## Contributors
[Fanan Dala](https://fanandala.com)

## License

This project is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
