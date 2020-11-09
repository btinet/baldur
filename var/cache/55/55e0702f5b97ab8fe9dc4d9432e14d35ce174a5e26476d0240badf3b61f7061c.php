<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* base.html.twig */
class __TwigTemplate_3740514b332afc62400391bab6eec06ea59d260750518820b80edd21a1569798 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <title>Title</title>
</head>
<body>
";
        // line 8
        $this->displayBlock('body', $context, $blocks);
        // line 12
        echo "
<p><?= \$user ?></p>
<p><?= \$password ?></p>
<p><?= \$password_verified ?></p>

<?php
    foreach (\$categories as \$category){
     echo \$category['title'].'<br>';
    }
?>

<table>
    <tr>
        <?php
        for (\$i = 1; \$i <= 7; \$i++){
            echo '<td>'.\$i.'</td>';
        }
        ?>
    </tr>

</table>



</body>
</html>";
    }

    // line 8
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 9
        echo "<h1>Tolle Sache</h1>
<h3>";
        // line 10
        echo twig_escape_filter($this->env, ($context["controller_name"] ?? null), "html", null, true);
        echo "</h3>
";
    }

    public function getTemplateName()
    {
        return "base.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  85 => 10,  82 => 9,  78 => 8,  49 => 12,  47 => 8,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "base.html.twig", "C:\\xampp\\htdocs\\templates\\base.html.twig");
    }
}
