<?php
echo "aaa";

   $allowed_tags =
      '<a><br><b><h1><h2><h3><h4><i><img><li><ol><p><strong><table>' .
      '<tr><td><th><u><ul><em><span>';
    $profile = strip_tags(" <img src=\"<script>\" />", $allowed_tags);
	echo $profile;

?>
