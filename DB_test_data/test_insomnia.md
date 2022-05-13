# Insomnia API testing


//===============================================//
//================== test name ==================//
//===============================================//
**route**
``

**json test**
``


## Users routes

//================================================//
//=================== users login ================//
//================================================//
**route**
`http://localhost:8080/api/users/login`
`http://alerafart-server.eddi.cloud/projet-10-meet-dev-back/public/api/users/login`
`http://aliciamv-server.eddi.cloud/projet-10-meet-dev-back/public/api/users/login`

**json test**
```json
{
	"email_address":"mcbernard@mc.cz",
	"password": "fifi"
}
```

//================================================//
//================ create user dev ===============//
//================================================//
**route**
`http://localhost:8080/api/users/developers`
`http://alerafart-server.eddi.cloud/projet-10-meet-dev-back/public/api/users/developers`
`http://aliciamv-server.eddi.cloud/projet-10-meet-dev-back/public/api/users/developers`

**json test**
```json
{
	"lastname": "ale",
	"firstname": "rrrr",
	"city": "stgo",
	"zip_code": 78740,
	"department":78,
	"email_address": "ale@feeling.io",
	"password": "ale",
	"phone": "060000000",
	"subscribe_to_push_notif":0,
	"profile_picture": "ale.png",

	"label": "dev specialise react",
	"description":"tttttttttjsfhjfhgjshgfjqskhghk",
	"available_for_recruiters":1,
	"available_for_developers":0,
	"minimum_salary_requested":2000,
	"age":42,
	"languages":"react, php, css",
	"years_of_experience":1,
	"english_spoken":"yes",
	"github_link":"",
	"portfolio_link":"",
	"other_link":"",
	"language":"php"
}
```

//================================================//
//============== create user recrut ==============//
//================================================//
**route**
`http://localhost:8080/api/users/recruiters`
`http://alerafart-server.eddi.cloud/projet-10-meet-dev-back/public/api/users/recruiters`
`http://aliciamv-server.eddi.cloud/projet-10-meet-dev-back/public/api/users/recruiters`

**json test**
```json
{
	"lastname":"Dubois",
	"firstname":"Marie-Jeanne",
	"city":"Caen",
    "department":78,
	"zip_code":14118,
	"email_address":"mjdubois@dubois.be",
	"phone":"949649649",
	"password":"aaaa",
	"subscribe_to_push_notif":0,
	"profile_picture":"pic.png",
	"description":"hello", 
	"available_for_recruiters":1,
	"available_for_developers":0,
	"minimum_salary_requested":40000,
	
	"company_name": "blabla"
}
```

//================================================//
//======== loading profiles search results =======//
//================================================//
**route**
`http://aliciamv-server.eddi.cloud/projet-10-meet-dev-back/public/api/secure/users/search`
`http://localhost:8080/api/secure/users/search`

**json test**
```json
{
	"language":"PHP",
	"city":"Caen",
	"exp":1
}
```


## Messages routes

//================================================//
//======= Retrieve all Messages from a User ======//
//================================================//
**route**
`http://localhost:8080/api/secure/messages/users/{id}`

**json test**
```json

```

//================================================//
//======= Retrieve one Message from a User =======//
//================================================//
**route**
`http://localhost:8080/api/secure/messages/users`

**json test**
```json
{
    "correspondantId": 8,
    "devId": 11
  }
```

//================================================//
//=========== Create Message from User ===========//
//================================================//
**route**
`http://localhost:8080/api/secure/messages`

**json test**
```json
{
    "receiver_user_id": 8,
    "sender_user_id": 11,
	"title": "holaaaa",
    "message_content": "message du user 11 a reciever 8",
    "signature": "Envoyé par user 11"
  }
```


## Favorites routes

//===============================================//
//====== retrieve all fav from one profile ======//
//===============================================//
**route**
``
`http://localhost:8080/api/secure/favorites/recruiters/{id}`

**json test**
`http://aliciamv-server.eddi.cloud/projet-10-meet-dev-back/public/api/secure/favorites/recruiters/{id}`


//===============================================//
//======= retrieve one fav from a profile =======//
//===============================================//
**route**
`http://aliciamv-server.eddi.cloud/projet-10-meet-dev-back/public/api/secure/favorites/recruiters`
`http://localhost:8080/api/secure/favorites/recruiters`

**json test**
`{
	"devId":5,
	"recrutId":2
}`
