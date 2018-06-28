# Wedding Website

## Workflow (SourceTree)
* **Commit small, commit often!**
* Using Terminal (Command Line)
    1. `git checkout -b [my-feature] master` - create new branch based on your up-to-date local master branch
    1. make edits and save the file(s) with your text editor
    1. `git add [file.ext]` - stage changes made to each file
    1. `git commit -m "Message with specifics"` - commit changes to [my-feature] branch
    1. `git checkout master` - switch to local master branch
    1. `git pull origin master` - pull changes from remote repo
    1. `git checkout [my-feature]` - switch back to local [my-feature] branch
    1. `git rebase master` - update local [my-feature] branch with new changes pulled from remote repo
    1. `git checkout master` - switch back to local master branch
    1. `git merge [my-feature]` - merge commits from local [my-feature] branch into local master branch
    1. `git branch -d [my-feature]` - delete local [my-feature] branch since commits now exist on master
    1. `git push origin master` - push changes to remote repository