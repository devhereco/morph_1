# Laravel 10 Project with FilamentPHP Control Panel

This project, created by Mohammed Baobaid (m.baobaid@outlook.com), serves as a control panel where users can register, log in, create posts, and interact with them. Additionally, administrators have enhanced privileges such as managing posts and comments.

## Purpose of the Project

This project is specifically developed for applying to the Morph training opportunity.

### User Functionality

- **Registration/Login**: Users can register an account and log in securely.
    - *Example*: To register, navigate to `/register` and fill in the required details.

- **Post Creation**: Authenticated users can create new posts.
    - *Example*: After logging in, access `/posts` to compose a new post.

- **Edit/Delete Posts and Comments**: Authenticated users have the ability to modify or delete their posts and comments.
    - *Example*: Access your post or comment and use the provided options to edit or delete.

### Admin Privileges

- **Universal Post Deletion**: Administrators possess the authority to delete all posts, overriding any restrictions.
    - *Example*: Log in with an admin account and navigate to the post you want to delete.

- **Admin-Specific Restrictions**:
    - Admins cannot edit any posts, except their own.

- **Admin Validation**:
    - Admin validation is based on email domain matching the APP_URL in the .env file, ignoring the protocol `HTTPS or HTTP`.
    - *Example*: If the APP_URL in the .env is `http://morph-1.test`, an admin's email like `admin@morph-1.test` will grant admin privileges.

### Important Notes:

- User and admin functionalities are divided to ensure security and differentiated access levels.
- Admins must adhere to the specific email domain rule for validation.

## Installation and Setup

1. Clone the repository:
   ```bash
   git clone https://github.com/devhereco/morph_1
   ```

2. Install dependencies:
   ```bash
    composer install
   ```
   
3. Set up your environment variables:
   Copy .env.example to .env and configure your database connection and other settings.
4. Generate application key:
   ```bash
    php artisan key:generate
   ```
5. Run Migrations:
   ```bash
    php artisan migrate
   ```
6. Serve the application:
   ```bash
    php artisan serve
   ```
7. Access the application via your browser at http://localhost:8000.s




