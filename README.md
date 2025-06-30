# PHP Test Project

### The priorities
1. Implementing robust security against common vulnerabilities (XSS, CSRF, SQLi, Clickjacking) using secure code practices and HTTP security headers 
2. Providing great UI/UX: Live search, smooth SPA-like experience

### The trade-oofs
1. In the code there are few comments of places where code could have been extracted to a partial, or DRY-ied up. All those places are noted, and can be polished to perfection easily. Since I didn't want to spend more than 4 hours, I didn't do it now.
2. It would be great improvement on UI/UX if the mobile phone field allowed user to choose the extension number by selecting their country's flag. Not done in this iteration.
3. Code in general could be structured much better, can be cleaner, with early exists and all, broken up in more files, but for me it was important to really only spend hours.
4. No tests are added. I've prioritized having robust security and great UI/UX.

### Description
At Better Stack, we don’t just ship features—we craft great products. This assignment is about more than just checking off tasks; it’s your opportunity to show us how you think, how you build, and how you care about user experience.

We ask you to build a very simple one-page application consisting of a single table and a form for creating new rows. To make it a little more complicated, we have written a 'framework' you have to use. Please write production-ready code.


### Installation
1. Create a private GitHub repository and invite @jurajmasar and @gyfis and @PetrHeinz as collaborators
2. Create a new MySQL database
3. Rename `config/database` to `config/database.php` and configure your database connection settings in this file
4. Import `database/schema.sql` into your database

### What we’re looking for
We want to see how you approach building software that real users would enjoy using. Treat this as if it were a real-world product for adding users to a table. 

We expect you to spend no more than 4 hours on this project. That means you’ll need to prioritize, make trade-offs, and focus on what matters—just like in real-world product development. 

Try your best to show us you are the engineer who knows when to go “quick and dirty” and when to polish production code to perfection, as described in this post: https://juraj.blog/p/two-sides

Please, start with these:
  * Styling the page using [Bootstrap](http://getbootstrap.com/) or [Tailwind](https://tailwindcss.com/)
  * Adding validation of new records
  * Creating a JS search functionality that allows users to filter records by city
  * Implementing form submission using AJAX
  * Adding a phone number column to the table
  * Deploying your project and sending us a production link
  * … however, this is not a perfect checklist. So please, don’t limit yourself to these points—engineering at Better Stack isn’t about simply completing a list of tasks. It’s about engineers shipping a great piece of software end-to-end that people will actually enjoy using!

We’re looking forward to seeing what you come up with!
Thank you! 🙏
