## Important Notes

- XAMPP, PHP Framework Laravel (version 5.4), MySQL has been used to do this assignment.
- Screenshots of various features of the web application are inside "Screenshots of Application" folder. 
- "project_db.sql" is the Database dump file.

## How to Run the Application

After downloading the assignment, following steps are needed to be done to run the application

- Apache and MySQL service module have to be started, these can be started from XAMPP control panel.
- The unzipped assignment has to be placed inside xampp's htdocs folder.
- A new database named "project_db" has to be created.
- From cmd, we need to go inside assignment folder, or cmd can be opened inside assignment folder. Path will be something like this: G:\SoftwarePractice\xampp\htdocs\Assignment (in windows).
- In cmd, we have to give the following command: "php artisan migrate", this command will create the necessary tables in the "project_db" database.
- One row has to be created at "slugs" table. This can be done manually, the "id" field must be "1", no need to give any new value to "slugcount"(default should be "1"), current time should be given to "created_at" and "updated_at" field. One row has to be created at "comment_slugs" table. This can be done manually, the "id" field must be "1", no need to give any new value to "slugcount"(default should be "1"), current time should be given to "created_at" and "updated_at" field. The insertions of these two rows to these two tables can also be done from cmd by using command "php artisan tinker", some other commands are also needed. A screenshot with necessary commands for this can be found at "Screenshot for inserting data at slugs and comment_slugs table" folder.
- We need to give command "php artisan serve" from cmd. An address will be given. The application can be accessed from that address.