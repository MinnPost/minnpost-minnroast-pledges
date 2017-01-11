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

## Local development

You should be able to use Postgres or MySQL for local development, although with either one you have to use PDO. This may require some installation work with the local PHP, depending on how you run it. Homebrew can achieve this, but it does require a lot of flags.

You will also have to set the `include_path` variable. The easiest way is:

```
<IfModule mod_php5.c>
php_value include_path ".:/local-path-to-site-root/"
</IfModule>
```

You will also need to set up the `.env` file with variables for your local install. You should be able to start with the `.env-sample` file in the repository by duplicating the file as `.env`.