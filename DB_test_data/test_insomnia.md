# Insomnia API testing


//===============================================//
//================== test name ==================//
//===============================================//
**route**
``

**json test**
``


//================================================//
//======== loading profiles search results =======//
//================================================//
**route**
`http://aliciamv-server.eddi.cloud/projet-10-meet-dev-back/public/api/users/search-results`

**json test**
```json
{
	"language":"PHP",
	"city":"Caen",
	"exp":1
}
```


//================================================//
//======== users login =======//
//================================================//
**route**
`http://localhost:8080/api/users/login`
`http://alerafart-server.eddi.cloud/projet-10-meet-dev-back/public/api/users/login`

**json test**
```json
{
	"email_address":"mcbernard@mc.cz",
	"password": "fifi"
}
```

//================================================//
//======== create user dev =======//
//================================================//
**route**
`http://localhost:8080/api/users/developer`
`http://alerafart-server.eddi.cloud/projet-10-meet-dev-back/public/api/users/developer`

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
//======== Create Message from User =======//
//================================================//
**route**
`http://localhost:8080/api/messagesUser`

**json test**
```json
{
    "receiver_user_id": 17,
    "sender_user_id": 4,
    "message_content": "message du user 4 a reciever 17",
    "signature": "Envoyé par user 4"
  }
```
