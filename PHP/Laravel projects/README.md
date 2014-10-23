This folder contains some files that are a part of the Laravel 4.1 PHP framework. They're not enough to build an application out of, but they do a good job of demonstrating my understanding of MVC concepts, server-side frameworks, and the basic structure that applications take on the server.

Please find a brief description of each file below:

* routes.php
    * This file performs URL routing for a site with role-based backend access. It primarily performs controller binding, telling the router that it should respond to /controller/method, but also places an authorization filter in front of protected routes, to prevent unauthorized access and allow for smooth login flow.
* models
	* These are some models pulled out of that same project. They're pretty light, but they demonstrate basic relationship-building amongst data objects.
* controllers
	* These are some controllers from the same project. They might be doing a little too much heavy lifting, needing to defer to helper libraries more, but I don't think any one is overly bloated.
	* LoginController.php does basic authorization and user creation.
	* SocialController.php works with the Laravel OAuth component to perform server authentication for some social APIs. It's the server-side code for `JavaScript/Client-side/social.js`

All files are primarily written by Tom Lagier. Boilerplate framework object class templates are provided by the Laravel framework.