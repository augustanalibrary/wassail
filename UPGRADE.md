#Upgrading from WASSAIL v3.2 to v3.3

####Backup, Backup, Backup...  
Not enough can be said about how important it is to backup - both your existing files, and your existing database - before upgrading WASSAIL


###OS/Software changes
WASSAIL 3.3 was built on a system running PHP v5.4.36, and MySQL v5.5.41.  However, v3.3 doesn't use any cutting edge functionality provided by those latest versions.

###Configuration changes
Database connection parameters (username, password, etc.) have been moved from `include/classes/dbi.php` to `include/config.db.php`.  Read the ["Update Configuration" section of the install guide](https://github.com/augustanalibrary/wassail/blob/master/INSTALL.md#update-configuration) for more information.

###Database changes
After upgrading WASSAIL, run these queries:

```sql
UPDATE
    `response`,
    `answer`
SET
    `response`.`answer_id` = 0
WHERE
    `answer`.`text` = 'No response was provided' AND
    `response`.`answer_id` = `answer`.`id`
```

```sql
ALTER TABLE
	`web_form` 
ADD COLUMN
	`file_count` tinyint(4) NOT NULL DEFAULT 1 AFTER `file_request`, 
ADD COLUMN
	`confirmation` text AFTER `name`
```

```sql
ALTER TABLE
	`response_id`
CHANGE COLUMN
	`filename` `filenames` text;
```