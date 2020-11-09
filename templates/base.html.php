<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
{% block body %}
<h1>Tolle Sache</h1>
<h3>{{ controller_name }}</h3>
{% endblock %}

<p><?= $user ?></p>
<p><?= $password ?></p>
<p><?= $password_verified ?></p>

<?php
    foreach ($categories as $category){
     echo $category['title'].'<br>';
    }
?>


</body>
</html>