# Irish Fitness
### Developed in Winter/Spring 2021 for CSE 30246 at Notre Dame
#### A collaboration between [Julia Buckley](https://github.com/juliafbuckley), [Stuart Hayden](https://github.com/shayden2), [Jake Hracho](https://github.com/jhracho), and [Chris Hunt](https://github.com/chunt4)

## About Irish Fitness
   Irish Fitness is a web application that allows students, faculty, and staff to better lead healthy lives on campus. We allow users to track basic health information, build nutritious meals from various Campus Dining locations, and plan productive workouts in on-campus gyms. There are features to view daily menus, select exercises that are viable with limited exercise equipment in some gyms, and the ability to draw running routes on a map of campus.
  Our target audience includes Notre Dame students and faculty interested in leading a healthy lifestyle while on campus. Similar fitness websites exist (eg. MyFitnessPal), but these apps do not work well with Campus Dining menus and limited availability of workout equipment on campus. Irish Fitness seeks to bridge the gap between Notre Dame and fitness tracking. Our project is useful because it allows this audience to track their lifestyle and make consistent improvements to better their health.

## Functionality 
- Home Page
   - Create daily calories and macro goals that update based on the food added for the day
   - Track total calories, meals, and workouts tracked for a user with "Account Milestones"
   - "Daily Review" graph that shows the net calories and macros based on meals and workouts added for the day 
- Meal Page
   - Selenium webscraper scrapes food daily from the Campus Dining website and automatically updates a MySQL database to reflect what food is being offered
   - Create meals by selecting individual foods and servings from any food option on campus (dining halls and flex point options)
   - Add custom food items for food eaten off campus
   - Save meals to be pre-loaded on future days
   - Navigate between the past weeks-worth of meals to make any changes necessary
- Workout Page
   - Create workouts based on target muscle and gym location
   - Exercises are filtered based on the equipment available at the selected gym
   - Draw a running route on a map of campus to have its distance calculated and added to your workout
   - View workouts with a demo link to each exercise
   - Save workouts to be pre-loaded on future days
- Profile Page
   - Update fitness goals, residence location, and other profile information

## Further Development
- Due to our webapp being hosted on a Notre Dame server, it can only be accessed from the Notre Dame network. We could spin up MySQL and Apache servers for this website to be run independently.
- Users should be able to save their running-route drawings and view them all in one place.

## Web Pages
