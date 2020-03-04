# marvel-backend-api

## Guidelines
This PHP app implements a basic API to search Marvel series and characters.

### Installations
- `brew update `
- `brew install php `
- `composer` (PHP dependency manager (e.g. npm, yarn, etc.)
	- https://getcomposer.org/download/ 
	

## Framework: Slim 4
- Slim is a PHP micro framework that helps you quickly write simple yet powerful web applications and APIs.
	- http://www.slimframework.com/docs/v4/start/installation.html	

## Database: MySQL
- If there are any issues authenticating to mySQL try the following command:
- ``` ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY ‘PASSWORD`; ```

## Drivers: PHP PDO
- PHP Data Object is an interface to work with mysql and other databases
To check whether the PDO MySQL driver is enabled, you need to open the  php.ini file and uncomment the following line by removing the semicolon ( ;) at the front of the entry:
- ``` extension=php_pdo_mysql.dll ```

## Tools: Git, CLI, Visual Code, Postman, MySQL Workbench 

## Folder Structure
> ` App `  
- Directory contains api for server requests
- Uses MVC to store Models, Controller, and Routes, (No view created for this project)
> ` sql_dump.sql ` 
- SQL file containing my database schema used to create my local database
> ` initDB `
- Directory contains scripts I developed to dynamically populate data from Marvel's api to my database which gave me a good amount of data to work with :)

## Config file required
```
define('HOST', '127.0.0.1');
define('DB_NAME','DB');
define('USER','USER');
define('PASS','PASS');
define('PUBLIC_KEY','MARVEL'S PUBLIC_KEY');
define('PRIVATE_KEY','MARVEL's PRIVATE_KEY');
define('BASE_URL','https://gateway.marvel.com:443');
```

## Run the app

``` php -S localhost:8080 ```

## RESTful URLs

### Series Request
* GET /v1/public/series/{titleStartsWith}
- ``` http://localhost:8080/v1/public/series?titleStartsWith=a ```

### Responses
```{
    "data": {
        "offset": 0,
        "limit": 20,
        "total": 1,
        "count": 1,
        "results": [
            {
                "id": "21112",
                "title": "A YEAR OF MARVELS: JUNE INFINITE COMIC (2016)",
                "description": null,
                "resourceURI": "http://gateway.marvel.com/v1/public/series/21112",
                "startYear": "2016",
                "endYear": "2016",
                "rating": "",
                "modified": "2019-09-05T14:24:57-0400",
                "urls": [
                    {
                        "type": "detail",
                        "url": "http://marvel.com/comics/series/21112/a_year_of_marvels_june_infinite_comic_2016?utm_campaign=apiRef&utm_source=1cba706a6d6294a1388a671d6a9e896d"
                    }
                ],
                "thumbnail": {
                    "path": "http://i.annihil.us/u/prod/marvel/i/mg/3/d0/575b3b86d5328",
                    "extension": "jpg"
                },
                "creators": {
                    "available": "4",
                    "collectionURI": "http://gateway.marvel.com/v1/public/series/21112/creators",
                    "items": [],
                    "returned": "4"
                },
                "characters": {
                    "available": "0",
                    "collectionURI": "http://gateway.marvel.com/v1/public/series/21112/characters",
                    "items": [],
                    "returned": "0"
                },
                "stories": {
                    "available": "2",
                    "collectionURI": "http://gateway.marvel.com/v1/public/series/21112/stories",
                    "items": [
                        {
                            "resourceURI": "http://gateway.marvel.com/v1/public/stories/126558",
                            "name": "cover from Junior Editor: TBD Infinite Comic E (2016) #1",
                            "type": null
                        },
                        {
                            "resourceURI": "http://gateway.marvel.com/v1/public/stories/126559",
                            "name": "story from Junior Editor: TBD Infinite Comic E (2016) #1",
                            "type": null
                        },
                        {
                            "resourceURI": "http://gateway.marvel.com/v1/public/comics/57928",
                            "name": "A YEAR OF MARVELS: JUNE INFINITE COMIC (2016) #1",
                            "type": null
                        }
                    ],
                    "returned": "2"
                },
                "comics": {
                    "available": "1",
                    "collectionURI": "http://gateway.marvel.com/v1/public/series/21112/comics",
                    "items": [],
                    "returned": "1"
                },
                "events": {
                    "available": "0",
                    "collectionURI": "http://gateway.marvel.com/v1/public/series/21112/events",
                    "items": [],
                    "returned": "0"
                }
	          }]
        }
     }
```

### Character Request
* GET  /v1/public/characters/{nameStartsWith}
- ``` http://localhost:8080/v1/public/characters?nameStartsWith=t ```

### Response
```
{
    "data": {
        "offset": 0,
        "limit": 20,
        "total": 4,
        "count": 4,
        "results": [
            {
                "id": "1009644",
                "name": "T'Challa",
                "description": "",
                "modified": "2012-05-23T12:12:57-0400",
                "resourceURI": "http://gateway.marvel.com/v1/public/characters/1009644",
                "thumbnail": {
                    "path": "http://i.annihil.us/u/prod/marvel/i/mg/b/40/image_not_available",
                    "extension": "jpg"
                },
                "comics": {
                    "available": "8",
                    "collectionURI": "http://gateway.marvel.com/v1/public/characters/1009644/comics",
                    "items": [
                        {
                            "resourceURI": "http://gateway.marvel.com/v1/public/comics/30862",
                            "name": "DOOMWAR TPB (Trade Paperback)"
                        },
                        {
                            "resourceURI": "http://gateway.marvel.com/v1/public/comics/69381",
                            "name": "Rise Of The Black Panther (Trade Paperback)"
                        },
                        {
                            "resourceURI": "http://gateway.marvel.com/v1/public/comics/75073",
                            "name": "Secret Warps: Ghost Panther Annual (2019) #1"
                        },
                        {
                            "resourceURI": "http://gateway.marvel.com/v1/public/comics/17475",
                            "name": "Storm (Trade Paperback)"
                        },
                        {
                            "resourceURI": "http://gateway.marvel.com/v1/public/comics/4061",
                            "name": "Storm (2006) #3"
                        },
                        {
                            "resourceURI": "http://gateway.marvel.com/v1/public/comics/4174",
                            "name": "Storm (2006) #4"
                        },
                        {
                            "resourceURI": "http://gateway.marvel.com/v1/public/comics/4274",
                            "name": "Storm (2006) #5"
                        },
                        {
                            "resourceURI": "http://gateway.marvel.com/v1/public/comics/4459",
                            "name": "Storm (2006) #6"
                        }
                    ],
                    "returned": "8"
                },
                "series": {
                    "available": "5",
                    "collectionURI": "http://gateway.marvel.com/v1/public/characters/1009644/series",
                    "items": [
                        {
                            "resourceURI": "http://gateway.marvel.com/v1/public/series/10161",
                            "name": "DOOMWAR TPB (2011)"
                        },
                        {
                            "resourceURI": "http://gateway.marvel.com/v1/public/series/25334",
                            "name": "Rise Of The Black Panther (2018)"
                        },
                        {
                            "resourceURI": "http://gateway.marvel.com/v1/public/series/26985",
                            "name": "Secret Warps: Ghost Panther Annual (2019)"
                        },
                        {
                            "resourceURI": "http://gateway.marvel.com/v1/public/series/357",
                            "name": "Storm (2006)"
                        },
                        {
                            "resourceURI": "http://gateway.marvel.com/v1/public/series/3307",
                            "name": "Storm (0000 - Present)"
                        }
                    ],
                    "returned": "5"
                },
                "stories": {
                    "available": "7",
                    "collectionURI": "http://gateway.marvel.com/v1/public/characters/1009644/stories",
                    "items": [
                        {
                            "resourceURI": "http://gateway.marvel.com/v1/public/stories/5474",
                            "name": "3 of 6 - 6XLS",
                            "type": "cover"
                        },
                        {
                            "resourceURI": "http://gateway.marvel.com/v1/public/stories/5476",
                            "name": "4 of 6 - 6XLS",
                            "type": "cover"
                        },
                        {
                            "resourceURI": "http://gateway.marvel.com/v1/public/stories/5478",
                            "name": "5 of 6 - 6XLS",
                            "type": "cover"
                        },
                        {
                            "resourceURI": "http://gateway.marvel.com/v1/public/stories/5480",
                            "name": "6 of 6 - 6XLS",
                            "type": "cover"
                        },
                        {
                            "resourceURI": "http://gateway.marvel.com/v1/public/stories/70532",
                            "name": "Cover #70532",
                            "type": "cover"
                        },
                        {
                            "resourceURI": "http://gateway.marvel.com/v1/public/stories/152861",
                            "name": "cover from RISE OF THE BLACK PANTHER TPB (2018) #1",
                            "type": "cover"
                        },
                        {
                            "resourceURI": "http://gateway.marvel.com/v1/public/stories/166985",
                            "name": "cover from new series (2019) #1",
                            "type": "cover"
                        }
                    ],
                    "returned": "7"
                },
                "events": {
                    "available": "0",
                    "collectionURI": "http://gateway.marvel.com/v1/public/characters/1009644/events",
                    "items": [],
                    "returned": "0"
                },
                "urls": [
                    {
                        "type": "detail",
                        "url": "http://marvel.com/comics/characters/1009644/tchalla?utm_campaign=apiRef&utm_source=1cba706a6d6294a1388a671d6a9e896d"
                    },
                    {
                        "type": "comiclink",
                        "url": "http://marvel.com/comics/characters/1009644/tchalla?utm_campaign=apiRef&utm_source=1cba706a6d6294a1388a671d6a9e896d"
                    }
                ]
            }
	      ]
    }
}
```

## Error Handling
* Request param `nameStartsWith` and `titleStartsWith` require a single letter value.
* Numbers are not allowed. 

### Example:

* Request 
` http://localhost:8080/v1/public/series `
Response
` {"Error":"Missing parameter 'titleStartsWith'."} `

* Request
` http://localhost:8080/v1/public/characters?nameStartsWith=3d `
Response
` {"Error":"Invalid entry for 'titleStartsWith' parameter."} `
