# Contribution Guidelines

This document outlines the general rules for contributing to
a project from this organization. More detailed and tailored
considerations will be found along with the specific project.

## Style

Any project must define a coding style to be used when writing
code. This should consist of a code formatter and linting pattern.  
All projects should make use of Github hooks for continuous
integration providers.

## Contributing code

### Branches
When adding a feature or fixing a bug, one must create a new
feature/fix branch with a name in this format:
```
{feat, fix}/<short title for feature/fix>(_<issue ID>)
```
Where:  
`feat` - a new feature or major update of existing functionality  
`fix`  - a bug fix or small correction  
`issue ID` - ID of the github issue related to the feature/fix (if available)

Examples:  
`feat/user_login`
`feat/user_keep_login_#10`
`fix/user_logout_after_refresh_#12`

### Commits

Commits should always have meaningful content. That means a commit
containing only a typo correction is undesirable.
A commit should also be constrained to a limited scope, at most
a related set of files, but better yet one file.
A commit message must have the following format:
```
{feat, fix}(<scope>): <short summary of feature/fix>
NEWLINE
<longer description of feature/fix>
```
A longer description is optional, but should be used if
the changes are not self-explanatory.

Example:
```
feat(src/views): add login page

add a user login page, with links for registration and password
reset
```

### Pull requests

To contribute the code the the master branch a pull request must
be opened.
The title must have the following format:
```
{feat, fix}: <short description of feature/fix>
```
The body must contain:
```
closes <issue ID>
```

### Review

Any addition to the master branch requires a review from a
contributing member of the project other than the person
working on the addition. Reviews should be requested once all
initial work on the feature/fix has been completed.

### Merging

All feature/fix branches must be rebased onto the master branch
before merging.
