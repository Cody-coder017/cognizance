# Cognizance

Cognizance is a tool for measuring cognitive function. In other words, it measures how well your brain is working.

Cognizance is available at http://polla.bhstudents.net/cognizance/.

## How it works

Cognizance provides four tests that measure cognitive function in different ways.  These tests are activities such as playing mobile games built into Cognizance.  The performance in these activities gets collected and summarized in a report.  The report can be reviewed to decide how safe it would be to do activities such as drive or operate heavy machinery.

## How to Make Cognizance Website Run Locally

This would be useful if you're planning to make changes to the website.

1. Install WAMP, XAMPP, or LAMP if you don't already have one of them.
1. Get all the files from this repository in one of your hosted directories such as www, htdocs, or public_html.
1. Create a database and initialize it by running db/init.sql.
1. Create a file called db/config.json and fill it with credentials for connecting to your database.  Fill in the following template:
```javascript
{
	"host": "localhost_or_any_hostname_you_want",
	"database": "your_db_name",
	"username": "your_db_username",
	"password": "your_db_users_password"
}
```
1. Run your *AMP and point your browser at the appropriate directory to see it working.

## Deploying on http://polla.bhstudents.net/cognizance/

Talk to Josh to deploy publicly.  The credentials are protected for security reasons.

## Public Web Hosting Environment

Here are some details on the public hosting environment used at http://polla.bhstudents.net/cognizance/.  They've been taken out of phpinfo results and could be useful.

- PHP version 5.6
- _SERVER['HTTP_HOST'] returns 'polla.bhstudents.net'.
- MySQL client API version: 5.6.32-78.1
- PDO MySQL driver is: mysqlnd 5.0.11-dev - 20120503 - $Id: 76b08b24596e12d4553bd41fc93cccd5bac2fe7a
