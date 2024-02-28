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
Login: please follow the images below
- copy link and space link into Postman: http://localhost:8765/api/users/login.json
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
 + Add Key, Value and Add to follow the images below:
```
Key : "Token"
Value : [copy from token in login response]
Add to: Header
```
![image](https://github.com/HieroPham/CakePHP2/assets/32766365/f8148657-fbc7-4ec0-8d24-0f8368bf7829)

### Article Management

TODO: pls summarize how to check "Article Management" bahavior

### Like Feature

TODO: pls summarize how to check "Like Feature" bahavior
