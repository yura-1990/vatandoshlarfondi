# Development Rules

Here are the development rules that all developers working on this project should follow:

## Branches

The following branches should be used in this project:

- `main`: This is the main branch and should only contain stable and tested code. This branch is deployed to production.
- `develop`: This is the development branch and should contain the latest code that is being worked on. This branch is deployed to staging.
- `feature/*`: This is a feature branch and should be used to develop a new feature. These branches should be created from the `develop` branch and merged back into it once the feature is complete.
- `hotfix/*`: This is a hotfix branch and should be used to fix a bug in production. These branches should be created from the `main` branch and merged back into it once the bug is fixed.

Each developer should work on their own `task-branch`, which should be created from `develop`. This will allow developers to work on their tasks independently and reduce the likelihood of code conflicts when merging their work back into the `develop` branch.


## Naming conventions

- Table columns should be in snake_case.
- Class properties should be in camelCase.
- Folder names should be in camelCase and start with uppercase

## Folder structure

Every class should be inside a folder of its own module. The folder structure should be organized in a way that makes it easy to navigate and understand the project's codebase.

## Code review

Every task should be reviewed before it is merged into the `develop` branch. This will ensure that the code quality is consistent and that potential issues are identified early on.

## Method body

Method bodies should be kept to a maximum of 15 lines to make them more readable and easier to understand.

## Service pattern

The service pattern should be used for logic in the project. This pattern helps to separate business logic from the rest of the code, making it easier to maintain and test.

## Documentation

Long logic methods should be documented to make them easier to understand and maintain. Documentation should be clear, concise, and provide context to the code.

## Commit changes

Developers should commit changes every day to ensure that code is backed up regularly and to make it easier to track changes in the project.

## Conclusion

By following these development rules, we can ensure that our project's codebase is organized, maintainable, and consistent. It will also help to streamline the development process and make it easier for developers to work collaboratively on the project.
