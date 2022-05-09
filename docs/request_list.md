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
RIGHT JOIN `developers` 
ON `users`.`dev_id` = `developers`.`id
```

### post
create new user
```sql
 INSERT INTO `users` (lastname, firstname, email_address, phone, password, dev_id, recrut_id, subscribe_to_push_notif, profile_picture)
 VALUES('value1', 'value2', 'value3',...valueN)
```




### put / patch
update

### delete
delete



## Developers entity

### get
getAll
getItem

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
