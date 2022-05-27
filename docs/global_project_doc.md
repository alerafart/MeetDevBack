# General project documentation

## Global controller organization and index
All controllers contains CRUD (Create Read Update Delete) functions. In addition to those, the following controllers contains additionnal methods described bellow. Both Developers and Recruiters Conrollers only contains CRUD method as all the users related method have been wrote either in the Users controller or the Auth controller.

### Users Controller
- Create a complete developer profile -> creation in the Users entity and Developers entity and add developer id into the user row.
- Create a complete recruiter profile -> creation in the Users entity and Recruiters entity and add Recruiter id into the user row.
- Update a complete developer profile -> update in the Users entity and affected Developers table row.
- Update a complete recruiter profile -> update in the Users entity and affected Recruiters table row.
- Login method
- Handle search results display -> fetch the complete profile of a developer according to search conditions.

### Messages Controller
- Get one message -> retrieve one message using its id; using a sender and a correspondant user id, this will also provide all complete profiles of both users.
- Get all messages from a user -> retieve all messages sent or received by one user, using their user id.
- Create new message -> this is the CRUD method slightly modify to send back in the JSON response the message sender id, correspondant id, title and content.

### Favorites Controller
- Get one favorite -> retrieve one favorite user complete profile using the id of the user logged in and the user id of the favorite user.
- Get all favorites from a user -> retieve all favorites profiles marked as favorite by a user, using their id.
- Add new favorite -> add a new favorite in the Favorites table using both users ids. 


*The bellow controllers work a bit differently since they are not linked directly to any Model or DB entity.*
### Auth Controller
This controller handles all the authentification related methods, which means everything linked to JWT token and email verification. So this does not contains any CRUD functions. 
- Register developers and register recruiters methods -> this is the basics complete profile creation methods described above in the Users controller upgraded to include the creation of a JWT token after the saving in the Users entity and in the specific second entity and sending a email address verification mail to the user.
- Login -> this is also the same as the Users controller login method but including a JWT token in the response.
- Logout
- me -> this returned the complete profile of a user using only the JWT token. The same one exists without JSON conversion to be use directly by nother component in the back-end. 
- Token creation -> token creation method calls by the above methods needing to include JWT in the response .
- Token refresh -> token refresh not use at the time as we called an external middleware on the routes to handle it.
- Email verification request -> this is the method handling the sending of the verification email to the user.
- Verify email -> is called once the user will click on the link provided in the email address verification email.

### Mail Controller
The mail controller doesn't contains any other method than the contactUser one.
This method handles the sending of an email to a user's mailbox and the creation in the DB Messages table.
The method is linked to the `ressources` folder which contains the markdown blade file and the custom components and CSS files.


## Middleware
### Authenticate middleware
This middleware is not used anymore as we now pass by the `jwt.auth` middleware providied by the Tymon\jwt-auth package.

### EnsureEmailsVerified middleware a.k.a Verified 
This middleware check if the user has a verified email in the DB or is currently verifying his email address before to grant access to all the routes it protects. It uses the MustVerifyEmail traits to check the DB.


## Models organization
The models contains mostly the table relationships and the default fields data. Some also use or implements specific packages or traits to allow the JWT authentification, email address verification and mail/notification send. The User model also contains method to retrieve a user using only JWT, the notification "route" to send it and an unused boot method to handle email address update in one user profile, firing a new verification email.


## Traits folder
Traits are small pieces of code that would be reused in diverse components of the app.
The Traits forlder contains a single MustVerifyEmail file which is used in the User model, Verify middleware and Auth controller to handle the email verification (both as a feature and access securing process).


## Routes files
The routes are divided into two files. The **web.php** file contains only CRUD methods that are not used in API requests. The **api.php** file contains all the API requests routes used in the front-end.


## Bootstrap/app.php
The app.php file contains all registration and declaration of the configuration files, services providers, routes files and middlewares. This is also the place where we can rename a middleware to something shorter to be used in the routes files.
If a file or provider is missing there, the app won't load it and therefore won't be able to use it. 


## Database folder
The DB folder contains all migration related folders. Which means the migrations themselves and the dummies data (factories and seeders files). Those process are described in the *DB_migration_doc.md*.

