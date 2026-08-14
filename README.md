# Slack DoorAccess Notification

Prototype proof-of-concept PHP website to notify when someone is at the door!

> [!WARNING]
> Webpage is in prototype and proof-of-concept phase and has not been security tested. Do not deploy for the public.

[IP-API](https://ip-api.com/) (the API lookup service used) [allows only 45 requests a minute](https://ip-api.com/docs/legal). You may be timeout if the page has high traffic. 

## How to use: 

* Login to the [Slack API](https://api.slack.com/apps?new_app=1) and make a new blank app. 
* Give the app a name and select the workspace it will be using. Hit create to make the app. 
* On the sidebar, navigate to `Features > Incoming Webhooks`. 
* Turn the feature on.
* Click `Add New Webhook`.
* Select which channel the webhook should post messages to, then click `Allow`.
* Copy the Webhook URL (be careful with this, it contains a secret).
* Throw the URL in the `$webhookURL` variable. 
* Deploy webpage on server running PHP. 