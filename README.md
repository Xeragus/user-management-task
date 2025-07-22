# SPA-like AJAX UI/UX & handling popular security vulnerabilities in simple PHP app

### The priorities
1. Implementing robust security against common vulnerabilities (XSS, CSRF, SQLi, Clickjacking) using secure code practices and HTTP security headers 
2. Providing great UI/UX: Live search, smooth SPA-like experience

### The trade-offs
1. In the code there are few comments of places where code could have been extracted to a partial, or DRY-ied up. All those places are noted, and can be polished to perfection easily. Since I didn't want to spend more than 4 hours, I didn't do it now.
2. It would be a great improvement on UI/UX if the mobile phone field allowed users to choose the extension number by selecting their country's flag. Not done in this iteration.
3. Code in general could be structured much better, can be cleaner, with early exits and all, broken up in more files, but for me it was important to really only spend hours.
4. No tests are added. I've prioritized having robust security and great UI/UX.
