#Upgrading from WASSAIL v3.2 to v3.3

####Backup, Backup, Backup...  
Not enough can be said about how important it is to backup - both your existing files, and your existing database - before upgrading WASSAIL


### OS/Software changes
WASSAIL 3.3 was built on a system running PHP v5.4.36, and MySQL v5.5.41.  However, v3.3 doesn't use any cutting edge functionality provided by those latest versions.


###Database changes
After upgrading WASSAIL, there are some database queries you'll need to run.  See the changelog for details.

**Run this:**
```sql
UPDATE
    response,
    answer
SET
    response.answer_id = 0
WHERE
    answer.text = 'No response was provided' AND
    response.answer_id = answer.id
```