# MinnPost Pledges

This is a basic app that runs on Heroku, and allows for us to collect pledge information from users. We can point any domain to this host, and can then add basic fields (title and a couple of messages, as well as a campaign ID) that correspond to the domain.

Based on that information, we store each pledge with its campaign, and the stats check the campaign.

## To add a new campaign

1. Register the domain, and point it to the Heroku hostname.
2. Add an entry to the campaigns table in the Heroku database.

'''
heroku pg:psql --app minnpost-pledges-test
'''

'''
INSERT INTO "campaigns" (url, title, main_label, thanks_label) VALUES ('domain','title','pledge headline','thanks headline','salesforceidforcampaign');
'''