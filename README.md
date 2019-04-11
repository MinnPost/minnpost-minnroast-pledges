# MinnPost Pledges

This is a basic app that runs on Heroku, and allows for us to collect pledge information from users. We can point any domain to this host, and can then add basic fields (title and a couple of messages, as well as a Salesforce campaign ID) that correspond to the domain.

Based on that information, we store each pledge with its campaign, and the stats check the campaign and the current year.

The campaign will be set based on the SALESFORCE_ID environment variable in Heroku, or the current domain, if the Salesforce ID is not present.

## Heroku Settings

The possible settings are listed in `.env-sample`. Here is what each setting is:

1. `DATABASE_URL`: Added by Heroku. We don't currently use it.
2. `HEROKU_POSTGRESQL_JADE_URL`: Added by Heroku. We don't currently use it.
3. `PAPERTRAIL_API_TOKEN`: For logging in Heroku. It is automatically added as well, if you use the addon.
4. `DATABASE_TYPE`: The database type for the PDO library. We use this so we can work with MySQL locally.
5. `DATABASE_HOST`: The host for the database.
6. `DATABASE_NAME`: The database name.
7. `DATABASE_USER`: The database user.
8. `DATABASE_PASS`: The database password.
9. `DATABASE_TABLE`: What table in the database to use. This is helpful for switching between a table full of test data and one full of real data.
10. `ALLOWED_DOMAINS`: A comma separated list of domains without the protocol. Ex: 'voteminnpost.dev,mrpledge.dev'
11. `SALESFORCE_ID`: An ID for a Salesforce campaign that corresponds to a campaign in the app's database. If you use this, currently, the app will only use that campaign.
12. `BOARD_SHOW_COUNT`: A true or false value for whether the board of pledges should show the total count.
13. `BOARD_SHOW_NAMES`: A true or false value for whether the board of pledges should rotate through names that are provided in the form.

## To add a new campaign

1. Register the domain, and point it to the Heroku hostname.
2. Add an entry to the campaigns table in the Heroku database.

```
heroku pg:psql --app appname
```

```
INSERT INTO "campaigns" (url, title, main_label, thanks_label, salesforce_id) VALUES ('domain','title','pledge headline','thanks headline','salesforceidforcampaign');
```

The `salesforce_id` field can be left off, but if it is the only way to set the campaign is by a domain.

## To update an existing campaign

1. Find the entry you want to update in the Heroku database.

```
heroku pg:psql --app appname
```

```
SELECT * FROM campaigns;
```

Find the `id` of the column you want to update.

2. Edit the info. For example, update the `main_label`.

```
UPDATE campaigns SET main_label = 'foo' WHERE id = 2;
```

## To export results from Heroku

Use [Dataclips](https://devcenter.heroku.com/articles/dataclips) to export results of a SQL query to share. They can be viewed in the browser at a unique URL that Heroku will create when the query runs, or they can be exported as JSON, CSV, XML, or Microsoft Excel documents.

Example query:

```
SELECT *
FROM pledges p
INNER JOIN campaigns c ON p.campaign = c.id
WHERE c.id = 1 AND date_part('year', created) = date_part('year', CURRENT_DATE)
```

Note: Heroku may have a lot of databases, even for the same app, so you might have to try more than once to find the one that has the data.

## Local development

You should be able to use Postgres or MySQL for local development, although with either one you have to use PDO. This may require some installation work with the local PHP, depending on how you run it. Homebrew can achieve this, and it appears to be built into PHP as of 2019.

You will need to set up the `.env` file with variables for your local install. You should be able to start with the `.env-sample` file in the repository by duplicating the file as `.env`.

You will need to set the `include_path` variable. This varies depending on your local development environment.

### Apache

```
<IfModule mod_php5.c>
php_value include_path ".:/local-path-to-site-root/"
</IfModule>
```

### Laravel Valet

If you use Laravel Valet, an easy way to achieve this is to create a file called `LocalValetDriver.php` in the root of your site. This file should contain the following code:

```php
<?php

class LocalValetDriver extends BasicValetDriver
{
    /**
     * Determine if the driver serves the request.
     *
     * @param  string  $sitePath
     * @param  string  $siteName
     * @param  string  $uri
     * @return bool
     */
    public function serves($sitePath, $siteName, $uri)
    {
        set_include_path( '/full-path-to-your-site-root/' );
        return true;
    }

}
```

### Database schema

Here is a schema of the required tables. You will want to create these to run the application locally.

#### MySQL

```sql
CREATE TABLE campaigns (
    id int(11) auto_increment NOT NULL,
    url text NOT NULL,
    title text NOT NULL,
    main_label text NOT NULL,
    thanks_label text NOT NULL,
    salesforce_id varchar(255) DEFAULT ''
, PRIMARY KEY(`id`)
);

CREATE TABLE pledges (
    id int(11) auto_increment NOT NULL,
    email text NOT NULL,
    amount numeric(50,2) NOT NULL,
    created timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    charge_if_on_file bool,
    campaign int(11) NOT NULL
, PRIMARY KEY(`id`)
);
```
