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

/* base/index.html.twig */
class __TwigTemplate_9a5a54b8c9454111466e946a158fdfb0b4fc7bb0d6a4e121859a4213aa4049d1 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("base.html.twig", "base/index.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 4
        echo "   <h1>
       <a href=\"";
        // line 5
        echo twig_escape_filter($this->env, $this->extensions['Core\Twig\Extension\FunctionExtension']->generateLink("base/index"), "html", null, true);
        echo "\">";
        echo twig_escape_filter($this->env, ($context["controller_name"] ?? null), "html", null, true);
        echo "</a>
   </h1>

    <ul>
        ";
        // line 9
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["categories"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["category"]) {
            // line 10
            echo "            <li>";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["category"], "title", [], "any", false, false, false, 10), "html", null, true);
            echo "</li>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['category'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 12
        echo "    </ul>

    <form method=\"post\">
        <label>
            User
            <input type=\"text\" name=\"user\">
        </label>
        <button type=\"submit\" name=\"submit\">Absenden</button>
    </form>

";
        // line 22
        echo twig_get_attribute($this->env, $this->source, ($context["flash"] ?? null), "show", [], "any", false, false, false, 22);
        echo "


";
    }

    public function getTemplateName()
    {
        return "base/index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  87 => 22,  75 => 12,  66 => 10,  62 => 9,  53 => 5,  50 => 4,  46 => 3,  35 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends 'base.html.twig' %}

{% block body %}
   <h1>
       <a href=\"{{ link('base/index') }}\">{{ controller_name }}</a>
   </h1>

    <ul>
        {% for category in categories %}
            <li>{{ category.title }}</li>
        {% endfor %}
    </ul>

    <form method=\"post\">
        <label>
            User
            <input type=\"text\" name=\"user\">
        </label>
        <button type=\"submit\" name=\"submit\">Absenden</button>
    </form>

{{ flash.show|raw }}


{% endblock %}", "base/index.html.twig", "C:\\xampp\\htdocs\\templates\\base\\index.html.twig");
    }
}
