# medical
## Installation
```shell script
$ git clone git@github.com:ibou/medical.git
```
## Create jwt config

```shell script
$ make create-dev-jwt  
$ mkdir -p var/export
```

## Install database

```shell script
$ make prepare-dev 
```

## If use symfony cli
### doc here : https://symfony.com/download
```
wget https://get.symfony.com/cli/installer -O - | bash
```

```shell script
$ symfony serve
```

## Links
* Front [http://localhost:8000] 
* Swagger api : [http://localhost:8000/api/docs] 

## Query Api with postman or insomnia
* Download Postman : https://www.postman.com/downloads/

## Authentification via Post
url : http://localhost:8000/authentication_token
method: POST
body->raw:
```json
    {
        "email": "idiallo@gmail.com",
        "password": "dev"
    }
```

```json
 {
     "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MDMyMDkwMjUsImV4cCI6MTYwMzIxMjYyNSwicm9sZXMiOlsiUk9MRV9BRE1JTiJdLCJlbWFpbCI6ImlkaWFsbG9AZ21haWwuY29tIn0.YznCtq2zAmtydYf_i4Dw6fhpz76kf6P79gl-jmW6uRqoXIhJ6XU4UEc-FAIEhv5qMu1Zr2TxlZQ-wC5Uf5bK3UqTyGbuh25A3MOtaUc4aPlrHFqAcI4TM14Fk5Kwmg3PD-aKvfh3tncdzr4RxCrcu0wHGGv97_XjVTp9KpcKCaA5mn-TuPsYRVkoHwZuD0-bsTfUTwOSjFj6nW7CJrN_2pBukjKhUPmcoCXMu06ZRwDe7zSq_gkw8sFU1GCkQVpWNPhhojZ9aAbj2jfl-VumI4HiSLyx-sbgY9BHmZuOekx4q0MB0vJOffyCWPGQPjW6HNOWsF3MHqgj9a480E189ZzL163TzoYXd1H2IitEDzVc_2YD3YWUOJKDmaPHXTjfONKAa-fBveInxdo77Ai8eAQuavjCPP6hbtnay8pAWiHJHmwjebNdQ9h0DDVUNvZjMboBv0pVPpwhfuZ-1rrLd5vVz_bjwdGndKf8A0M69sR3Plj31zgiSpopx1KLV-1PBNPETpPAB1drxCM3qWOTaa9iXgZPWx6hoBbO8i8PCXnpxyOAOdtivWeY4R209M9YFL4QVdTHrbCwLknEwAnaaJrA7gv0oXrTMeCYCs-aMBjRrq_6TMQTV2IBEq3JzOY-1GSH7KTznANLssiDgB4JhxOn5dCRY0QoCPg1HBoE2XQ"
 }
```
##Using curl
```json
$ curl -X POST "http://localhost:8000/authentication_token" -H  "accept: */*" -H  "Content-Type: application/json" -d "{\"email\":\"idiallo@gmail.com\",\"password\":\"dev\"}"
```

* Le résultat est un token.

url : http://localhost:8000/api/users
Method: GET
Authorization Bearer : [token]



 
