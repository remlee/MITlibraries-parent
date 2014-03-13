MITlibraries-parent
===================

The better-hours branch will rebuild how the MITLibraries-parent Wordpress theme handles hours.
-------------------

### Basic Structure

1. Define new post type, "Terms," or "Calendar Terms," etc.
2. Create a new "Term": ex. "Spring 2014"
3. Create new location pages as children of the term.
4. Each location gets a Mon-Sun set of default times. This way the majority of each location's hours for a particular term will be handled by a single post.
5. Each location could also be given a set of "exception" fields for defining special hours, holidays, etc., and/or "Holidays" could exist as a separate term for institute holidays.

### Example Tree View

		Summer 2014
			- Barker
				- Regular Hours (Mon. 8am-10pm; Tues. 8am-10pm; Wed. 8am-10pm; Thurs. 8am-10pm; Fri. 9am-9pm; Sat. 10am-9pm; Sun. 11am-8pm;)
				- Exceptions (7/7/14, closed; 8/2/14 12pm-8pm; etc.)
