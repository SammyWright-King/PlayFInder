# README #

This describes my approach at the task.

## Technical test ##

### Declarations ###
As specified by the task description/ deliverables

- 3 routes were defined in the router.php file
    - /{location}/forecast : which is to pull the weatherapi forecast for that location on the same day
    - /{location}/{id}-day : which is to pull the weatherapi forecast for that location for the entered number of days
    - {route:.*}: with a callback function to handle andy other routes to the system which was not earlier defined as 404

- The Task class was created with 2 methods to handle
    - ordianryForecast for only the location
    -daysForecast to forecast the weather in a location for "n" number of days
    
- In line with best practices, SOLID principle
    - The forecast and search interfaces were created to individually handle calls to the weatherapi endpoints needed
    - The repositories were injected into the BaseController which is then extended/inherited by the Task controller

### Approach ###
- to verify the location entered is valid on each api call
    - a call is first made to the weatherapi search endpoint on the location to verify if it returns with any data
    -if it does not, then the location entered is not valid
    -otherwise,
        - location is valid and you can now call the other endpoints on weatherapi

### Response ###   
 Response is in json format containing the relevant `date` and `forecast`
   - {"date": "2023-04-05", "forecast": "Patchy rain possible"}
   - [{"date": "2023-04-05", "forecast": "Patchy rain possible"}, {"date": "2023-04-06", "forecast": "Moderate Rain"}]

### Deliverables ###
- unit test for some of the class and methods used
- yaml file containing the swagger documentation

### Any clarifications? ###
kindly send a message to: 
[Olumuyiwa](sammywright.king@gmail.com) .
