Hello!

I've done the task as we spoke:
- Created a login/register
- Enabled the possibility of restoring the password, linked to a Mailtrap account.
- Admin user (determined by the is_admin flag in Users table) can add roles to the rest of the users,
this has been done enabling two views, differentiated by the flag is_admin or non admin.

I've kept Jquery and JS instead of React, for one reason, given the free time I've had for this task
I wasn't feeling comfortable with my React knowledge.

I'm attaching a DB with some users (removed the unit test ones):
admin@a.a => admin@1234
ana@a.a => ana@1234
paul@p.p => paul@1234

Database credentials can be found in .env file.
