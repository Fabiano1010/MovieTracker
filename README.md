# MOVIETRACKER <img  height="24" alt="movie_tracker_logo" src="https://github.com/user-attachments/assets/d64757b1-c748-4e79-8948-3b59949ce6ae" />





**MovieTracker** is a personal movie and TV series library application built with Laravel, Inertia and Vue. Users can create and manage their own collection of films and TV shows by searching the IMDb database, saving titles with custom statuses, ratings, and personal comments.

## Features

### Home Page
- Dynamic display of 50 most popular movies and series
- Carousel presentation showing 3 titles simultaneously
- CSS fade animation between featured content
- Current trending titles from streaming platforms and theaters
- Original title, primary title, and release date display
<img width="1845" height="948" alt="home_page" src="https://github.com/user-attachments/assets/3b67f737-e069-4bd2-abce-8d86f69a2aa6" />

### User Accounts
- User registration and login system
- Secure authentication
- Personalized dashboard for each user
<img width="1845" height="957" alt="Register" src="https://github.com/user-attachments/assets/65e61b7e-a2df-4fdc-8993-ab01d95b0c6f" />
<img width="1847" height="954" alt="login" src="https://github.com/user-attachments/assets/452db468-d73f-4704-bf3e-22f704bc4746" />

### Movie Database Search
- Integration with IMDb movie database
- Search functionality for movies and TV series
- Detailed view including plot, directors, writers, cast, genres, runtime, ratings, and review counts
- Accurate release year information
<img width="1841" height="956" alt="search" src="https://github.com/user-attachments/assets/f4941e04-f9c4-4c10-b378-6503b662650b" />
<img width="1842" height="954" alt="add" src="https://github.com/user-attachments/assets/497913c5-44de-46c0-8933-686b9e847d78" />

### Dashboard
- Overview of complete movie collection
- Filter options by status:
    - All
    - To Watch
    - In Progress
    - Finished
    - Favourite
- Sort by options:
    - Modified
    - Title
    - Release date
    - Personal rating
- Sort options:
    - Ascending
    - Descending
- Quick access to movie details and edit functions
- Display of status, user rating, and release year
<img width="1840" height="951" alt="dashboard" src="https://github.com/user-attachments/assets/dfe0dcd5-340b-441c-892c-b623e25e2f71" />

### Personal Collection Management
- Add movies to personal library with status options:
    - To Watch
    - In Progress
    - Finished/Watched
- Favorite movie checkbox for marking preferred titles
- Personal rating system (scale of 1-10)
- Private comment field for personal notes
- Edit functionality for status, rating, and comments
- Delete movies from collection
<img width="1844" height="958" alt="update" src="https://github.com/user-attachments/assets/b1b8dace-fa2a-491c-9ee1-3a96af58b805" />


### Statistics
- Total count of saved movies and series
- Status-based breakdown
- Progress tracking across collection
<img width="1844" height="959" alt="stats" src="https://github.com/user-attachments/assets/67175fac-590b-4a9c-aa0f-8682ca9fb439" />

## Technology Stack

- **Backend Framework:** Laravel
- **Frontend Framework:** Vue.js
- **Integration Layer:** Inertia.js
- **Styling:** Tailwind, CSS
- **Database:** MySQL
- **API Integration:** IMDb API
- **Animations:** CSS transitions

## Installation

1. Clone the repository
```
git clone https://github.com/Fabiano1010/MovieTracker.git
cd MovieTracker
```

2. Install PHP dependencies
```
composer install
```

3. Install NPM dependencies
```
npm install
```

4. Environment configuration
```
cp .env.example .env
php artisan key:generate
```

5. Configure database connection in .env file
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=movietracker
DB_USERNAME=root
DB_PASSWORD=
```

6. Run database migrations
```
php artisan migrate
```

7. Build frontend assets
```
npm run dev
```

8. Start development server
```
php artisan serve
```

## Usage Guide

1. **Registration and Login**
    - Create new account with username, email, and password
    - Login with existing credentials
    - Remember me functionality available

2. **Searching for Content**
    - Navigate to Search page
    - Enter movie or series title
    - Browse search results from IMDb database
    - View complete details before adding to collection

3. **Adding to Collection**
    - Select desired movie from search results
    - Choose status from dropdown menu
    - Set personal rating
    - Add private comment (Optional)
    - Mark as favourite if desired
    - Save to personal library

4. **Managing Collection**
    - Access Dashboard to view all saved titles
    - Use filters to narrow display by status
    - Sort collection 
    - Click Show to view full details
    - Edit status, rating, or comment
    - Delete titles from collection

5. **Statistics**
    - View collection metrics from Statistics section
    - Monitor number of titles in each status category
    - Track overall library growth

6. **Discovering New Content**
    - Home page displays current popular titles
    - Automatic rotation of featured content

## Key Components

- **Movie Search:** IMDb API service layer with Laravel HTTP client
- **Collection Management:** Vue components for CRUD operations
- **Dashboard:** Filterable and sortable data tables
- **Home Carousel:** Vue component with timed transitions
- **Statistics:** Aggregated database queries

## Database Schema

- **users** - Account information
- **user_movies** - User movie relationships with status, rating, comment, favorite flag

## License

This project is licensed under the MIT License.
