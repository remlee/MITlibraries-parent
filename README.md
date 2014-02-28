MITlibraries-parent
===================

The better-hours branch will rebuild how the MITLibraries-parent Wordpress theme handles hours.
-------------------

### Basic Structure

1. Define new post type, "Terms," or "Calendar Terms," etc.
2. Create a new "Term": ex. "Spring 2014"
3. Create new location pages as children of the term.
4. Each location gets a Mon-Sun set of default times. This way the majority of each location's hours for a particular term will be handled by a single post.
5. Each location could also be given a set of "exception" fields for defining special hours, holidays, etc.
