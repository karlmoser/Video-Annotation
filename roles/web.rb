name "web"
description "The web server"

run_list "recipe[apache2]", "recipe[php]", "recipe[nodejs]", "recipe[annotated.io]"