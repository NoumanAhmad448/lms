# Eren LMS Package - Comprehensive Guide

## Overview
The `Eren\Lms` package is a Laravel-based Learning Management System (LMS) that provides essential functionalities for managing courses, assignments, and video uploads. It supports instructor panels, Amazon S3 integration for video storage, and an admin approval system for publishing courses.

## Features
- **Instructor Panel**: Allows instructors to upload complete courses, including assignments and videos.
- **Amazon S3 Support**: Videos can be uploaded to Amazon S3 for efficient storage and delivery.
- **Admin Approval System**: Uploaded courses remain unpublished until reviewed and approved by an admin.
- **User Authentication**: Supports login, registration, and password recovery.
- **Middleware Support**: Includes `admin` and `authenticate` middleware for access control.
- **Publishable Assets**: Provides configuration files, views, translations, migrations, and other resources.

## Installation

1. **Install the package via Composer**:
   ```sh
   composer require eren/lms
   ```

2. **Publish the package assets**:
   ```sh
   php artisan vendor:publish --tag=lms_config
   php artisan vendor:publish --tag=lms_views
   php artisan vendor:publish --tag=lms_assets
   php artisan vendor:publish --tag=lms_lang
   php artisan vendor:publish --tag=lms_admin
   php artisan vendor:publish --tag=lms_requests
   php artisan vendor:publish --tag=lms_rules
   php artisan vendor:publish --tag=lms_only_header_footer_sidebar
   ```

3. **Run migrations**:
   ```sh
   php artisan migrate
   ```

## Middleware
The package provides the following middleware:
- **`admin`**: Restricts access to admin-only sections.
- **`authenticate`**: Ensures authentication for protected routes.

## Instructor Panel
- Instructors can upload full courses, including assignments and videos.
- Videos are stored on **Amazon S3**.
- The admin must approve courses before they become publicly accessible.

## Course Display
- Currently, the package does not include course display functionality.
- You can create a query to build a course listing page.

## Authentication
- The package supports **login**, **registration**, and **forgot password** functionalities.

## License
This package is open-source and available under the [MIT License](LICENSE).

## Contribution
Feel free to contribute by submitting issues or pull requests to the GitHub repository.

## Support
For any issues, open a GitHub issue or contact the package maintainer.

