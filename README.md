# Interview Testing App

## Overview

What's going on here? So.. This is the task implementation for an interview, with requirement details
located [here](./TASK.md). Before review, need to pay attention to the section below.

### Notable Solution Considerations:

- **Horizontal Layer Implementation**: Oh yes, we will not see classical vertical architecture style here. This
  architecture style is suitable only for apps, which will scale in functionality and complexity over time. In any case
  this example showcases how a module can be structured with a separation between the infra, logic, and presentation
  layers with clear dependency direction towards the domain layer. Each module is self-contained and can be easily
  removed due to transparent logical boundaries.

- **Expression Evaluation**: I've decided to find the correct answer through evaluating expressions at runtime on the
  server side. Although, of course, it is better to store the correct answers in DB - less code, simpler and faster. But
  it will be boring for a test task.

## API Controller Decisions

The application has several routes that demonstrate the basic functionality:

- `GET /api/testing/questions`: Fetches and randomizes the questions for the test.
- `POST /api/testing/evaluate`: Evaluates the submitted answers and returns the test results.
- `GET /api/testing/results`: Retrieves the test result stats.
- `DELETE /api/testing/results`: Clears all test result stats.

## How to run

To get the application up and running, follow these steps:

1. Clone the repository from GitHub.
2. Make sure, that's port 8080 has not been used.
3. Run `docker-compose up --build`.
4. Run migrations `docker-compose exec testing_app php /var/www/bin/console doctrine:migrations:migrate --no-interaction`
5. Open http://localhost:8080/.
