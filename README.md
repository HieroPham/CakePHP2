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

The API application should now be accessible at http://localhost:34251/api

## How to check
 - Please use Postman on PC or use website (donwload on https://www.postman.com/) for check API application.
### Authentication
- Please use sample user info created by Seed:
```
   'email': 'superadmin@gmail.com',
   'password': 'admin@123',

   'email': 'user@gmail.com',
   'password': 'user@123',
```
TODO: pls summarize how to check "Authentication" bahavior

### Article Management

TODO: pls summarize how to check "Article Management" bahavior

### Like Feature

TODO: pls summarize how to check "Like Feature" bahavior
