# URF Pickem
Made by Air Nomad Smitty and Kilometers42 hailing from the NA server.
Manufactured in Minnesota, USA
##Description
With URF Pick'em, we animate a gold graph and update champion KDAs as the game is progressing. The object of the game is to pick the winner of the game as early on as possible. The earlier you pick, the more points you get. Keep guessing until you get one wrong, then save your score to the leaderboard. Demo server is available here: http://ec2-54-148-243-198.us-west-2.compute.amazonaws.com/

##Dependencies
    - "aura/cli-kernel": "~2.0",
    - "aura/web-kernel": "~2.0",
    - "aura/sql"       : "~2.0",
		- "aura/view"      : "~2.0",
		- "aura/session"   : "~2.0"

    We utilized different pieces of the Aura PHP framework for our backend. These allowed us to handle routing, views, session changes, and database interaction easily.
    
    - "monolog/monolog": "~1.0"
    
    For some request logging
        
		- "guzzlehttp/guzzle" : "~5.0"
		
		The crowd favorite PHP library for hitting APIs
		
		- Angular JS
		- Bootstrap JS
