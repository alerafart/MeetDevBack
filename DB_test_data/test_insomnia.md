# Insomnia API testing

## DB 

`http://alerafart-server.eddi.cloud/adminer/?username=explorateur&db=meetdev&table=users`
`http://aliciamv-server.eddi.cloud/adminer/?username=explorateur&db=meetdev&table=users`


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
//================= Update user ==================//
//================================================//
**route**
`http://localhost:8080/api/secure/users/11`
`http://aliciamv-server.eddi.cloud/projet-10-meet-dev-back/public/api/secure/users/11`

**json test**
```json
{
	"lastname":"updatetestupdate",
	"firstname":"testupdate",
	"city":"update",
	"department":91,
	"zip_code":14118,
	"phone":"9496496494545",
	"subscribe_to_push_notif":0,
	"profile_picture":"pic.png",
	
	"label":"poodle",
	"description":"test test test test", 
	"available_for_recruiters":1,
	"available_for_developers":0,
	"minimum_salary_requested":40000,
	"age":14,
	"languages":"rubyyyyy, CCCCC",
	"years_of_experience":2,
	"english_spoken":"updateee test",
	"github_link":"github.git.com",
	"portfolio_link":"portfolio.com",
	"other_link":"",
	"language": "PHP",
		
	"company_name": "fifi",
	"needs_description": "hjksqdf"
}
```
*requête unique pour recrut ou dev, le filtrage se fait en back. Mpd + adresse email à ne pas envoyer*


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
    "messageId": 11
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

//================================================//
//=========== Send a Message to a User ===========//
//================================================//
**route**
`http://localhost:8080/api/users/send/email`

**json test**
```json
{
	"email":"maalejandrarafart@gmail.com"
}
```

//================================================//
//===== Send a Message to a User & save in DB ====//
//================================================//
**route**
`http://aliciamv-server.eddi.cloud/projet-10-meet-dev-back/public/api/users/contact`
`http://localhost:8080/api/users/contact`

**json test**
```json
{
    "testEmail":"milekic.alicia@gmail.com", 
	"sender_user_id": 1,
    "receiver_user_id":32,
    "message_title":"Ahoj",
    "message_content":"Lorem ipsum dolor sit amet, conse"
}
```


## Favorites routes

//===============================================//
//====== retrieve all fav from one profile ======//
//===============================================//
**route**
``
`http://localhost:8080/api/secure/favorites/recruiters/{id}`
`http://aliciamv-server.eddi.cloud/projet-10-meet-dev-back/public/api/secure/favorites/recruiters/{id}`

**json test**
``

//===============================================//
//======= retrieve one fav from a profile =======//
//===============================================//
**route**
`http://aliciamv-server.eddi.cloud/projet-10-meet-dev-back/public/api/secure/favorites/recruiters`
`http://localhost:8080/api/secure/favorites/recruiters`

**json test**
`{
	"devUserId":5,
	"recrutUserId":2
}`
*ids are from the **users** entity*

//===============================================//
//=========== add new fav to a profile ==========//
//===============================================//
**route**
`http://aliciamv-server.eddi.cloud/projet-10-meet-dev-back/public/api/secure/favorites/recruiters`
`http://localhost:8080/api/secure/favorites/recruiters`

**json test**
`{
	"devUserId":6,
	"recrutUserId":51
}`

//===============================================//
//========= delete a fav from a profile =========//
//===============================================//
**route**
`http://aliciamv-server.eddi.cloud/projet-10-meet-dev-back/public/api/secure/favorites/6`
`http://localhost:8080/api/secure/favorites/11`

**json test**
``

***takes favorite id as parameter***


## JWT test routes

//===============================================//
//========= JWT registration recruiters =========//
//===============================================//
**route**
`http://aliciamv-server.eddi.cloud/projet-10-meet-dev-back/public/api/register/recruiters`
`http://localhost:8080/api/register/recruiters`

**json test**
`{
	"lastname":"Dubois",
	"firstname":"Jacquemort",
	"city":"Caen",
	"department":78,
	"zip_code":14118,
	"email_address":"dubois.jacques@blabla.com",
	"phone":"949649649",
	"password":"blabla",
	"subscribe_to_push_notif":0,
	"profile_picture":"pic.png",
	
	"company_name": "fifi",
	"needs_description": "hjksqdf"
}`

//===============================================//
//========= JWT registration developers =========//
//===============================================//
**route**
`http://aliciamv-server.eddi.cloud/projet-10-meet-dev-back/public/api/register/developers`
`http://localhost:8080/api/register/developers`

**json test**
`{
	"lastname":"Vyzva",
	"firstname":"Janine",
	"city":"Caen",
	"department":78,
	"zip_code":14118,
	"email_address":"test@test.blabla",
	"phone":"949649649",
	"password":"test",
	"subscribe_to_push_notif":0,
	"profile_picture":"pic.png",
	
	"label":"poodle",
	"description":"hello", 
	"available_for_recruiters":1,
	"available_for_developers":0,
	"minimum_salary_requested":40000,
	"age":48,
	"languages":"ruby, C",
	"years_of_experience":2,
	"english_spoken":"very well indeed",
	"github_link":"github.git.com",
	"portfolio_link":"portfolio.com",
	"other_link":"",
	"language": "PHP"
}`

//===============================================//
//============= JWT login recruiters ============//
//===============================================//
**route**
`http://aliciamv-server.eddi.cloud/projet-10-meet-dev-back/public/api/login`
`http://localhost:8080/api/login`

**json test**
`{
	"email_address":"ldlc@gmail.com",
	"password":"ldlc"
}`

//===============================================//
//=========== JWT displaying profile ============//
//===============================================//
**route**
`http://aliciamv-server.eddi.cloud/projet-10-meet-dev-back/public/api/me`
`http://localhost:8080/api/me`

**json test**
*authentification -> Bearer Token*
`Bearer Q1lDUmDvfl5ymWG9AFU2jWL9iY7nsioeaTDcq3ni5FE`
