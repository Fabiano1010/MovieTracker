# MOVIETRACKER

MOVIETRACKER is a personal movie and TV series library application built with Laravel, Inertia and Vue. Users can create and manage their own collection of films and TV shows by searching the IMDb database, saving titles with custom statuses, ratings, and personal comments.

## Features

### User Accounts
- User registration and login system
- Secure authentication
- Personalized dashboard for each user

### Home Page
- Dynamic display of 50 most popular movies and series
- Carousel presentation showing 3 titles simultaneously
- CSS fade animation between featured content
- Current trending titles from streaming platforms and theaters
- Original title, primary title, and release date display

### Movie Database Search
- Integration with IMDb movie database
- Search functionality for movies and TV series
- Detailed view including plot, directors, writers, cast, genres, runtime, ratings, and review counts
- Accurate release year information

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

### Statistics
- Total count of saved movies and series
- Status-based breakdown
- Progress tracking across collection

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

## Application Structure

```
movietracker/
├── app/
│   ├── Http/
│   │   ├── Controllers/     # Request handling
│   │   └─── Middleware/      # Authentication and request filtering      
│   └── Models/              #  Models      
├── database/
│   ├── migrations/          # Database schema
│   └── seeders/            # Test data
├── resources/
│   ├── css/                # CSS
│   ├── img/                # Logo
│   ├── js/
│   │   ├── Components/     # Vue components
│   │   ├── Layouts/        # Page layouts
│   │   └── Pages/          # Inertia page components
│   └── views/              # PHP blade views
└── routes/
    └── web.php             # Application routes
```

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
