## Get Started

This guide will walk you through the steps needed to get this project up and running on your local machine.

### Prerequisites

Before you begin, ensure you have the following installed:

- Docker
- Docker Compose

### Building the Docker Environment

Build and start the containers:

```
docker-compose up -d --build
```

### Installing Dependencies

```
docker-compose exec app sh
composer install
```

### Database Setup

Set up the database:

```
bin/cake migrations migrate
```
Set up sample data for User and Articles by Seed

```
bin/cake migrations seed --seed UsersSeed
```
```
bin/cake migrations seed --seed ArticlesSeed
```

### Accessing the Application

The API application should now be accessible at http://localhost:8765/api

## How to check
Please use Postman on PC or use website (donwload on https://www.postman.com/) for check API application.
### Authentication
Please use sample user info to login:
```
   'email': 'superadmin@gmail.com',
   'password': 'admin@123',

   'email': 'user@gmail.com',
   'password': 'user@123',
```
Login to get token for Authentication:
- copy this link and space link into new tab on Postman:
   ```
  http://localhost:8765/api/users/login.json
   ```
- Choose Method : POST
- Add Body (raw ->JSON) 
```
  {
      "email": "superadmin@gmail.com", 
      "password": "admin@123"
  }
```
![image](https://github.com/HieroPham/CakePHP2/assets/32766365/59435aae-96fa-4501-a789-19d1dc824fd8)

Use Token from data response for Feature API which have authenticated
 + Check Feature API need to Authorization.
 + Select Tab Authorization
 + Chose Type "API key"
 + Add Key, Value and Add to:
```
Key : Token
Value : [copy token from login response]
Add to: Header
```
![image](https://github.com/HieroPham/CakePHP2/assets/32766365/f8148657-fbc7-4ec0-8d24-0f8368bf7829)

### Article Management

1. #### Retrieve All Articles: (permission: All User can get)
   - copy this link and space link into new tab on Postman:
    ```
    http://localhost:8765/api/articles.json
    ```
   - Choose Method : GET

2. #### Retrieve a Single Article: (permission: All User can get)
   - copy this link and space link into new tab on Postman:
    ```
    http://localhost:8765/api/articles/1.json
    ```
   - Choose Method : GET

3. #### Create an Article (permisison: Can only be used by authenticated users)
   - copy this link and space link into new tab on Postman:
    ```
    http://localhost:8765/api/articles.json
    ```
   - Choose Method : POST
   - Add token from login response to Authorization.

* Case 1: Authenticated Users
  - Add Body(type->raw->JSON):
    ```
    {
    "title" : "Article New",
    "body" : "This is new new Article for demo"
    }
    ```
  => Response:
    ```
    {
    "status": "success",
    "data": {
        "title": "Article New",
        "body": "This is new new Article for demo",
        "user_id": 1,
        "created_at": "2024-02-28 04:35:18.257882",
        "updated_at": "2024-02-28 04:35:18.257888",
        "id": 12
    },
    "message": "Add article successfully."
   }
    ```
* Case 2: Add Wrong Data:
  - Add Body(type->raw->JSON):
    ```
      {}
    ```
    => Response:
    ```
    {
       "status": "error",
       "message": "Add article fail!"
    }
    ```

* Case 3: Not Authenticated Users:
   - logout user by link:  http://localhost:34251/api/users/logout.json (GET).
   - Add Body(type->raw->JSON):
    ```
    {
    "title" : "Article New",
    "body" : "This is new new Article for demo"
    }
    ```
  => Response:
     ```
     "Authentication is required to continue"
     ```


4. #### Update an Article (permission: Can only be used by authenticated article writer users.)
    - copy this link and space link into new tab on Postman:
    ```
    http://localhost:8765/api/articles/1.json
    ```
   - Choose Method : PUT
* Case 1: uthenticated article writer users
   - login by superadmin@gmail.com.
   - get token from login reponse and add it into Authorization on Update an Article API tab.
   - add Body:
   ```
   {
    "title" : "Article Update",
    "body" : "Update Article from super admin"
   }
   ```
   =>Response
   ```
   {
    "status": "success",
    "data": {
        "id": 8,
        "user_id": 1,
        "title": "Article Update",
        "body": ""Update Article from super admin",
        "created_at": "2024-02-27T16:57:32+00:00",
        "updated_at": "date": "2024-02-27 17:47:13.179462"
        }
    "message": "Update article successfully."
   }
   ```
* Case 2: Update Wrong Data:
    - Edit link on tab on Postman:
    ```
    http://localhost:8765/api/articles/10.json
    ```
    => Response:
    ```
    {
    "status": "error",
    "message": "article not found!"
    }
    ```
* Case 3: uthenticated users but not is article writer 
   - login by user@gmail.com.
   - get token from login reponse and add it into Authorization on Update an Article API tab.
   - add Body:
   ```
   {
    "title" : "Article Update",
    "body" : "Update Article from super admin"
   }
   ```
   =>Response: 
   ```
   {
    "status": "error",
    "message": "You do not have permission to update this article!"
   }
   ```

* Case 4: Not Authenticated Users
    - logout user by link:  http://localhost:34251/api/users/logout.json (GET).
    - Add Body(type->raw->JSON):
    ```
    {
    "title" : "Article Update",
    "body" : "Update Article from super admin"
    }
    ```
    => Response:
    ```
    "Authentication is required to continue"
    ```

5. #### Delete an Article (permission: Can only be used by authenticated article writer users):
    - copy this link and space link into new tab on Postman:
    ```
    http://localhost:8765/api/articles/1.json
    ```
   - Choose Method : DELETE

Case 1: uthenticated article writer users
   - login by superadmin@gmail.com.
   - get token from login reponse and add it into Authorization on Update an Article API tab.
   =>Response
   ```
   {
    "status": "success",
    "message": "Delete article successfully."
   }
   ```

* Case 2: Delete Wrong Data:
    - Edit link on tab on Postman:
    ```
    http://localhost:8765/api/articles/100.json
    ```
    => Response:
    ```
    {
    "status": "error",
    "message": "article not found!"
    }
    ```

* Case 3: uthenticated users but not is article writer 
   - login by user@gmail.com.
   - get token from login reponse and add it into Authorization on Update an Article API tab.
   ```
   =>Response: 
   ```
   {
    "status": "error",
    "message": "You do not have permission to delete this article!"
   }
   ```

* Case 4: Not Authenticated Users
    - logout user by link:  http://localhost:34251/api/users/logout.json (GET).
    => Response:
    ```
    "Authentication is required to continue"
    ```

### Like Feature

1. #### Like an Article
 - copy this link and space link into new tab on Postman:
    ```
    http://localhost:8765/api/articles/like/1.json
    ```
- Choose Method : POST
- Add token from login response to Authorization.

* Case 1: Authenticated Users
  - Add token from login response to Authorization.
  => Response:
    ```
   {
    "status": "success",
    "message": "like article successfully."
   }
    ```

* Case 2: Authenticated Users already like an Article
  => Response:
    ```
   {
       "message": "you already liked this article!"
   }
    ```

* Case 3: Add Wrong Data:
  - edit link on tab on Postman:
    ```
    http://localhost:8765/api/articles/like/100.json
    ```
    => Response:
    ```
   {
    "status": "error",
    "message": "article not found!"
   }
    ```

* Case 4: Not Authenticated Users:
   - logout user by link:  http://localhost:34251/api/users/logout.json (GET).
  => Response:
     ```
     "Authentication is required to continue"
     ```

2. #### Retrieve All Articles with Like count: (permission: All User can get)
   - copy this link and space link into new tab on Postman:
    ```
    http://localhost:8765/api/articles.json
    ```
   - Choose Method : GET
   => Response:
   ```
   {
       "status": "success.",
        "data": [
           {
              "id": 1,
              "user_id": 1,
              "title": "admin article 1",
              "body": "This is Admin article 1",
              "created_at": "2024-02-27T05:05:05+00:00",
              "updated_at": "2024-02-27T05:05:05+00:00",
              "user": {
                  "email": "superadmin@gmail.com"
              },
              "like_count": 1
           },
           {
               "id": 2,
               "user_id": 1,
               "title": "admin article 2",
               "body": "This is Admin article 2",
               "created_at": "2024-02-27T05:05:05+00:00",
               "updated_at": "2024-02-27T05:05:05+00:00",
               "user": {
                   "email": "superadmin@gmail.com"
               },
               "like_count": 0
           },
       [
   }
   ```

3. #### Retrieve a Single Article with Like count: (permission: All User can get)
   - copy this link and space link into new tab on Postman:
    ```
    http://localhost:8765/api/articles/1.json
    ```
   - Choose Method : GET
   => Response:
   ```
   {
       "status": "success.",
       "data": {
           "id": 1,
           "user_id": 1,
           "title": "admin article 1",
           "body": "This is Admin article 1",
           "created_at": "2024-02-27T05:05:05+00:00",
           "updated_at": "2024-02-27T05:05:05+00:00",
           "user": {
               "email": "superadmin@gmail.com"
           },
           "like_count": 1
       }
   }
   ```

