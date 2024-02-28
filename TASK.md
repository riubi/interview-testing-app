# Interview Coding Task

The task is to create a simple testing system that supports questions with fuzzy logic and the ability to choose multiple answer options. 

What are questions with fuzzy logic?

For example:

"2 + 2 ="

1) 4
2) 3 + 1
3) 10

The correct answers here would be 1 OR 2 OR (1 AND 2). Any other combinations (for example, 1 AND 3) will not be considered correct, even though they contain a correct answer.

## Expected Outcome

- A link to GitHub / Bitbucket with the source code and deployment instructions.
- The project should be containerized with Docker.
- Users should be able to go through the test from start to finish and at the end see two lists - questions they answered correctly and questions where the answers contained errors.
- It should be possible to take the test an unlimited number of times.
- Each test result should be saved in the database (displaying results is not necessary).
- (Optional) Both questions and answers for each question should be displayed to the user in random order with each new test session.

## Requirements

- The task must be completed using Symfony and PostgreSQL.
- Appearance is not important, no authorization is required, no admin panel is needed, it is enough to add questions with answers to the database once.