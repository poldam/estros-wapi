# estros-wapi
Plugin Description
Passes as json info about selected posts Plugin (through: 'wp-content/plugins/estros-wapi/json/json.php').

Encryption and arguments
post_type (optional): pass the post_type you want to retrieve (returns published posts). Default post_type is 'post'.
category (optional): pass tehj post category you want to retrieve. Default category is 0, return posts from all categories.
token (mandatory): token is created after hashing the concatenated result of the first argument and the encryption key set in the preferences section.
themes (optional): get inbformation about installed themes and active theme (themes=on).
plugins (optional): get inbformation about installed plugins and active plugins (plugins=on).
categories (optional): get all the post categories (category list) that have at least one post (categories=on).
post_types (optional): get all the post types available (post_types=on).

Demo Key and hash
Key: polyvios
First argument: post_type=page
Hash: token=f61805147c8aeaaa3385c2d3583d4b0f
For 'item' posts use the link:
/wp-content/plugins/estros-wapi/json/json.php?post_type=item&token=088c3a238c08ac374cb10827fd648b1b 