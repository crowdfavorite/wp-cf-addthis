# CF AddThis

This plugin provides a simple interface to create sharing links for any of the services [AddThis][1] offers. It hits the GET API directly, creating plain, simple HTML links without Javascript lightboxes, etc for ultimate customization.

The template tag to create a link is `cfat_share`. By default the link will share the current page URL and current page title. If you pass in a service name (see DocBlock in `cf-addthis.php` for details) the link will share directly to that service, otherwise it will pull up the AddThis sharing portal page.

You can also get the url for a service using the `cfat_get_url` function.

[1]:http://www.addthis.com/