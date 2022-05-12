# Request list

## Users entity

### GET queries
getAll
getItem

get dev_id from a specific user
```sql
SELECT `dev_id` FROM `users` 
WHERE `users`.`id` = $userId
```

get recrut_id from a specific user
```sql
SELECT `recrut_id` FROM `users` 
WHERE `users`.`id` = $userId
```

get all data from all users who have dev_id
```sql
SELECT * FROM `users` 
RIGHT JOIN `developers` 
ON `users`.`dev_id` = `developers`.`id
```

get all data from one dev profile (Users + Developers)
```sql
SELECT * FROM `users` 
JOIN `developers` 
ON `users`.`dev_id` = `developers`.`id`
AND `developers`.`id`=$devId
```
==
```sql
SELECT * FROM `users` , `developers`
WHERE `users`.`dev_id` = `developers`.`id` 
AND `developers`.`id`=$devId
```

get all data from one recruit profile (Users + Recruiters)
```sql
SELECT * FROM `users` 
JOIN `recruiters` 
ON `users`.`recrut_id` = `recruiters`.`id`
AND `recruiters`.`id`=$recrutId
```

get all data from all users who have recrut_id
```sql
SELECT * FROM `users` 
RIGHT JOIN `recruiters` 
ON `users`.`recrut_id` = `recruiters`.`id
```

get users id based on a known $language
```sql
SELECT `users`.`id` FROM  `users`, `developers`,  `languages` , `dev_langs`
WHERE  `languages`.`id` = `dev_langs`.`language_id`
AND `developers`.`id` = `dev_langs`.`developer_id`
AND `developers`.`id` = `users`.`id`
AND `languages`.`language_name`= $language
```

get all devs profiles based on a known $language and $city and $exp (dev + users tables)
```sql
SELECT * FROM `users` 
JOIN `developers` 
ON `developers`.`id` = `users`.`dev_id` 
AND `users`.`city`= $city
AND `developers`.`years_of_experience` = $exp
AND `users`.`dev_id` IN
    (SELECT `developers`.`id` FROM  `developers`,  `languages` , `dev_langs`
    WHERE  `languages`.`id` = `dev_langs`.`language_id`
    AND `developers`.`id` = `dev_langs`.`developer_id`
    AND `languages`.`language_name`= $language)
```

get all devs profiles based on a known $language (dev + users tables)
```sql
SELECT * FROM `users` 
JOIN `developers` 
ON `developers`.`id` = `users`.`dev_id` 
AND `users`.`dev_id` IN
    (SELECT `developers`.`id` FROM  `developers`,  `languages` , `dev_langs`
    WHERE  `languages`.`id` = `dev_langs`.`language_id`
    AND `developers`.`id` = `dev_langs`.`developer_id`
    AND `languages`.`language_name`= $language)
```


### POST queries
create new user
```sql
 INSERT INTO `users` (lastname, firstname, city, zip_code, email_address, phone, password, dev_id, recrut_id, subscribe_to_push_notif, profile_picture)
 VALUES('value1', 'value2', 'value3',...valueN)
```

create new dev user (users + dev tables) (for complete profile creation see [dev_id insertion into user row] (#dev_id-insertion-to-users))
```sql
INSERT INTO `users` (lastname, firstname, city, zip_code, email_address, phone, password, dev_id, recrut_id, subscribe_to_push_notif, profile_picture)
VALUES('value1', 'value2', 'value3',...valueN);
INSERT INTO `developers` (description, available_for_recruiters, available_for_developers, minimum_salary_requested,maximum_salary_requested, age, years_of_experience, github_link, portfolio_link, other_link)
 VALUES('value1', 'value2', 'value3',...valueN)
```

create new recruiter user (users + recrut tables) (for complete profile creation see [recrut_id insertion into user row] (#recrut_id-insertion-to-users))
```sql
INSERT INTO `users` (lastname, firstname, city, zip_code, email_address, phone, password, dev_id, recrut_id, subscribe_to_push_notif, profile_picture)
VALUES('value1', 'value2', 'value3',...valueN);
INSERT INTO `recruiters` (company_name, needs_description, web_site_link)
 VALUES('value1', 'value2', ...valueN)
```

### PUT/ PATCH queries
update user profile based on $userId
```sql
UPDATE `users`
SET `lastname`='value', `firstname`='value', `city`='value', `zip_code`='value', `email_address`='value@value', `phone`='value', `password`='value', `subscribe_to_push_notif`=0, `profile_picture`='value'
WHERE `users`.`id` = $userId
```

update user and developer profile based on $userId (users + dev tables)
```sql
UPDATE `users`
SET `lastname`='value', `firstname`='value', `city`='value', `zip_code`=0, `email_address`='value@value', `phone`='value', `password`='value', `subscribe_to_push_notif`=0, `profile_picture`='value'
WHERE `users`.`id` = $userId;
UPDATE `developers`
SET `description`='value', `available_for_recruiters`=0, `available_for_developers`=0, `minimum_salary_requested`=0, `maximum_salary_requested`=0, `age`=0, `years_of_experience`=0, `github_link`='github.github', `portfolio_link`='portfolio.portfolio', `other_link`='other.link'
WHERE `developers`.`id` = 
    (SELECT `dev_id` FROM `users` WHERE  `users`.`id`=$userId)
```

<a name="dev_id-insertion-to-users">dev_id insertion into users table specified row</a>
```sql
UPDATE `users`
SET `dev_id` = $devId
WHERE `users`.`id` = $userId 
```

<a name="recrut_id-insertion-to-users">recrut_id insertion into users table specified row</a>
```sql
UPDATE `users`
SET `recrut_id` = $recrutId
WHERE `users`.`id` = $userId 
```

### DELETE queries
delete



## Developers entity

### GET queries
getAll
getItem

get id of devs who marked $language as known
```sql
SELECT `developers`.`id` FROM `developers`,  `languages` , `dev_langs`
WHERE  `languages`.`id` = `dev_langs`.`language_id`
AND `developers`.`id` = `dev_langs`.`developer_id`
AND `languages`.`language_name`= $language
```

### POST queries
create new developer 
```sql
 INSERT INTO `developers` (description, available_for_recruiters, available_for_developers, minimum_salary_requested,maximum_salary_requested, age, years_of_experience, github_link, portfolio_link, other_link)
 VALUES('value1', 'value2', 'value3',...valueN)
```

### PUT/ PATCH queries
update

### DELETE queries
delete



## Recruiters entity

### GET queries
getAll
getItem


### POST queries
create new recruiter 
```sql
 INSERT INTO `recruiters` (company_name, needs_description, web_site_link)
 VALUES('value1', 'value2', ...valueN)
 ```

### PUT/ PATCH queries
update



### DELETE queries
delete



## Messages entity

### GET queries
getAll
getItem

### POST queries
create new message 
```sql
 INSERT INTO `messages` (receiver_user_id, sender_user_id, message_content, signature)
 VALUES('value1', 'value2', ...valueN)
 ```

### PUT/ PATCH queries
update

### DELETE queries
delete



## Languages entity

### GET queries
getAll
getItem

get languages names associated to a dev profile using id 
```sql
SELECT `language_name` FROM `languages` , `developers`, `dev_langs`
WHERE  `languages`.`id` = `dev_langs`.`language_id`
AND `developers`.`id` = `dev_langs`.`developer_id`
AND `developers`.`id`=$devId
```

### POST queries
insert new row into entity
```sql
INSERT INTO `languages` (language_name)  
VALUES ('php');
```

### PUT/ PATCH queries
update

### DELETE queries
delete



## Favorites entity

### GET queries
getAll
getItem

### POST queries
create new favorite 
```sql
 INSERT INTO `favorites` (developer_id, recruiter_id)
 VALUES('value1', 'value2', ...valueN)
 ```

### PUT/ PATCH queries
update

### DELETE queries
delete


# Missing requests in controllers

- Search query with 3 critera (experience, city, language),
- Get all favorites from a recruiter profile;
- Get one favorite with all user data from a recruiter profile,
- Register new favorite in DB,
- Get all messages from a user,
- Get one message with details from a users profile,
- Register new message in DB,
