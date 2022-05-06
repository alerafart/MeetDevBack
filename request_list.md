# Request list

## Users entity

### get
getAll
getItem

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


### post
create new user
```sql
 INSERT INTO `users` (lastname, firstname, city, zip_code, email_address, phone, password, dev_id, recrut_id, subscribe_to_push_notif, profile_picture)
 VALUES('value1', 'value2', 'value3',...valueN)
```

### put / patch
update user profile based on user id
```sql
UPDATE `users`
SET `lastname`='value', `firstname`='value', `city`='value', `zip_code`='value', `email_address`='value@value', `phone`='value', `password`='value', `dev_id`=1, `recrut_id`=1, `subscribe_to_push_notif`=0, `profile_picture`='value'
WHERE `users`.`id` = 2
```

### delete
delete



## Developers entity

### get
getAll
getItem

get id of devs who marked $language as known
```sql
SELECT `developers`.`id` FROM `developers`,  `languages` , `dev_langs`
WHERE  `languages`.`id` = `dev_langs`.`language_id`
AND `developers`.`id` = `dev_langs`.`developer_id`
AND `languages`.`language_name`= $language
```

### post
create new developer 
```sql
 INSERT INTO `developers` (description, available_for_recruiters, available_for_developers, minimum_salary_requested,maximum_salary_requested, age, years_of_experience, github_link, portfolio_link, other_link)
 VALUES('value1', 'value2', 'value3',...valueN)
```

### put / patch
update

### delete
delete



## Recruiters entity

### get
getAll
getItem

### post
create new recruiter 
```sql
 INSERT INTO `recruiters` (company_name, needs_description, web_site_link)
 VALUES('value1', 'value2', ...valueN)
 ```

### put / patch
update

### delete
delete



## Messages entity

### get
getAll
getItem

### post
create new message 
```sql
 INSERT INTO `messages` (receiver_user_id, sender_user_id, message_content, signature)
 VALUES('value1', 'value2', ...valueN)
 ```

### put / patch
update

### delete
delete



## Languages entity

### get
getAll
getItem

get languages names associated to a dev profile using id 
```sql
SELECT `language_name` FROM `languages` , `developers`, `dev_langs`
WHERE  `languages`.`id` = `dev_langs`.`language_id`
AND `developers`.`id` = `dev_langs`.`developer_id`
AND `developers`.`id`=$devId
```

### post
insert new row into entity
```sql
INSERT INTO `languages` (language_name)  
VALUES ('php');
```

### put / patch
update

### delete
delete



## Favorites entity

### get
getAll
getItem

### post
create new favorite 
```sql
 INSERT INTO `favorites` (developer_id, recruiter_id)
 VALUES('value1', 'value2', ...valueN)
 ```

### put / patch
update

### delete
delete
