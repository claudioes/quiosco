<?php

/* articulo/index.twig */
class __TwigTemplate_2d8d2bb6b6085d1caded8eb1cf40a7a690f16d9b4cdc314bfa27c3b370e76fce extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 2
        $this->parent = $this->loadTemplate("template/base.twig", "articulo/index.twig", 2);
        $this->blocks = array(
            'css' => array($this, 'block_css'),
            'jsapp' => array($this, 'block_jsapp'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "template/base.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $context["form"] = $this->loadTemplate("template/macro/form.twig", "articulo/index.twig", 1);
        // line 2
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 4
    public function block_css($context, array $blocks = array())
    {
        // line 5
        echo "    <style>
        input.editable {
            width: 80px !important;
        }
        input.success-post {
            background: #c8ffb1 !important;;
        }
    </style>
";
    }

    // line 15
    public function block_jsapp($context, array $blocks = array())
    {
        // line 16
        echo "    <script src=\"";
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('siteUrlWithVersion')->getCallable(), array("js/app/articulo.js")), "html", null, true);
        echo "\"></script>
    <script>
        \$(function () {
            App.Articulo.Index();
        })
    </script>
";
    }

    // line 24
    public function block_content($context, array $blocks = array())
    {
        // line 25
        echo "    <h1>Artículos</h1>

    <div id=\"toolbar\" class=\"btn-toolbar\" role=\"toolbar\">
        <div class=\"btn-group\" role=\"group\">
            <a href=\"";
        // line 29
        echo twig_escape_filter($this->env, $this->env->getExtension('Slim\Views\TwigExtension')->urlFor("Articulo:create"), "html", null, true);
        echo "\" class=\"btn btn-success\">
                <i class=\"glyphicon glyphicon-plus\"></i> Nuevo
            </a>
        </div>
        <div class=\"btn-group\" role=\"group\">
            <a href=\"";
        // line 34
        echo twig_escape_filter($this->env, $this->env->getExtension('Slim\Views\TwigExtension')->urlFor("Articulo:aumento"), "html", null, true);
        echo "\" class=\"btn btn-default\">
                Aumento
            </a>
        </div>
    </div>

    <div class=\"table-responsive\">
        <table id=\"table\" class=\"table table-bordered table-hover\" width=\"100%\">
            <thead>
                <tr>
                    <th>Cód</th>
                    <th style=\"width:100%\">Descripción</th>
                    <th>Stock</th>
                    <th>Costo</th>
                    <th>Ganancia</th>
                    <th>Precio Venta</th>
                    <th></th>
                </tr>
            </thead>
        </table>
    </div>
";
    }

    public function getTemplateName()
    {
        return "articulo/index.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  80 => 34,  72 => 29,  66 => 25,  63 => 24,  51 => 16,  48 => 15,  36 => 5,  33 => 4,  29 => 2,  27 => 1,  11 => 2,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% import \"template/macro/form.twig\" as form %}
{% extends \"template/base.twig\" %}

{% block css %}
    <style>
        input.editable {
            width: 80px !important;
        }
        input.success-post {
            background: #c8ffb1 !important;;
        }
    </style>
{% endblock %}

{% block jsapp %}
    <script src=\"{{ siteUrlWithVersion('js/app/articulo.js') }}\"></script>
    <script>
        \$(function () {
            App.Articulo.Index();
        })
    </script>
{% endblock %}

{% block content %}
    <h1>Artículos</h1>

    <div id=\"toolbar\" class=\"btn-toolbar\" role=\"toolbar\">
        <div class=\"btn-group\" role=\"group\">
            <a href=\"{{ urlFor('Articulo:create') }}\" class=\"btn btn-success\">
                <i class=\"glyphicon glyphicon-plus\"></i> Nuevo
            </a>
        </div>
        <div class=\"btn-group\" role=\"group\">
            <a href=\"{{ urlFor('Articulo:aumento') }}\" class=\"btn btn-default\">
                Aumento
            </a>
        </div>
    </div>

    <div class=\"table-responsive\">
        <table id=\"table\" class=\"table table-bordered table-hover\" width=\"100%\">
            <thead>
                <tr>
                    <th>Cód</th>
                    <th style=\"width:100%\">Descripción</th>
                    <th>Stock</th>
                    <th>Costo</th>
                    <th>Ganancia</th>
                    <th>Precio Venta</th>
                    <th></th>
                </tr>
            </thead>
        </table>
    </div>
{% endblock %}
", "articulo/index.twig", "G:\\www\\quiosco\\app\\Views\\articulo\\index.twig");
    }
}
