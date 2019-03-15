# switchart-api

REST API for switchart-ui

Routes all return JSON formatted eloquent collection

Routes:


```
authentication routes used to generate JWT
post api/register
post api/login
post api/logout


all Switch Games in database
get api/games 

specfic game where {name} has all non alphanumeric characters stripped and spaces converted to _ eg: Splatoon 2 = Splatoon_2
get api/games/{name}

used to add games to database, admin protected route
post api/games/store

post with a userId to get that user
post api/users/show

users upload artwork here, must be signed in
post api/artwork/store

gets artwork by artworkId
get api/artwork/id/{id}

gets all artwork for a given name 
get api/artwork/game/{name}

toggle upvote status on artwork, must be logged in
post api/vote/upvote/

toggle downvote status on artwork, must be logged in
post api/vote/downvote/

gets net vote count on a given artwork
get api/vote/artwork/{id}
```
