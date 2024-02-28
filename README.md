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
Key : "Token"
Value : [copy from token in login response]
Add to: Header
```
![image](https://github.com/HieroPham/CakePHP2/assets/32766365/f8148657-fbc7-4ec0-8d24-0f8368bf7829)

### Article Management

1. Get Articles Listing: ( All User can get)
   - copy this link and space link into new tab on Postman:
    ```
    http://localhost:8765/api/articles.json
    ```
   - Choose Method : GET
2. Get Article Detail: ( All User can get)
   - copy this link and space link into new tab on Postman:
    ```
    http://localhost:8765/api/articles/1.json
    ```
   - Choose Method : GET
3. Create new Article (Can only be used by authenticated users)
   - copy this link and space link into new tab on Postman:
    ```
    http://localhost:8765/api/articles.json
    ```
   - Choose Method : POST
* Case 1: Authenticated Users
  - Add token from login response to Authorization.
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
        "created_at": {
            "date": "2024-02-28 04:35:18.257882",
        },
        "updated_at": {
            "date": "2024-02-28 04:35:18.257888",
        },
        "id": 12
    },
    "message": "Add article successfully."
   }
    ```
* Case 2: Not Authenticated Users:
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
   * Case 3: Wrong Data
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
4. Edit Article
### Like Feature

TODO: pls summarize how to check "Like Feature" bahavior
